<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    @push('styles')
        <style>
            /* Variables */

            form {
                width: 30vw;
                min-width: 500px;
                align-self: center;
                box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
                    0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
                border-radius: 7px;
                padding: 40px;
            }

            #payment-message {
                color: rgb(105, 115, 134);
                font-size: 16px;
                line-height: 20px;
                padding-top: 12px;
                text-align: center;
            }

            #payment-element {
                margin-bottom: 24px;
            }

            /* Buttons and links */
            #btnSubmit {
                background: #5469d4;
                font-family: Arial, sans-serif;
                color: #ffffff;
                border-radius: 4px;
                border: 0;
                padding: 12px 16px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                display: block;
                transition: all 0.2s ease;
                box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
                width: 100%;
            }

            #btnSubmit:hover {
                filter: contrast(115%);
            }

            #btnSubmit:disabled {
                opacity: 0.5;
                cursor: default;
            }

            /* spinner/processing state, errors */
            .spinner,
            .spinner:before,
            .spinner:after {
                border-radius: 50%;
            }

            .spinner {
                color: #ffffff;
                font-size: 22px;
                text-indent: -99999px;
                margin: 0px auto;
                position: relative;
                width: 20px;
                height: 20px;
                box-shadow: inset 0 0 0 2px;
                -webkit-transform: translateZ(0);
                -ms-transform: translateZ(0);
                transform: translateZ(0);
            }

            .spinner:before,
            .spinner:after {
                position: absolute;
                content: "";
            }

            .spinner:before {
                width: 10.4px;
                height: 20.4px;
                background: #5469d4;
                border-radius: 20.4px 0 0 20.4px;
                top: -0.2px;
                left: -0.2px;
                -webkit-transform-origin: 10.4px 10.2px;
                transform-origin: 10.4px 10.2px;
                -webkit-animation: loading 2s infinite ease 1.5s;
                animation: loading 2s infinite ease 1.5s;
            }

            .spinner:after {
                width: 10.4px;
                height: 10.2px;
                background: #5469d4;
                border-radius: 0 10.2px 10.2px 0;
                top: -0.1px;
                left: 10.2px;
                -webkit-transform-origin: 0px 10.2px;
                transform-origin: 0px 10.2px;
                -webkit-animation: loading 2s infinite ease;
                animation: loading 2s infinite ease;
            }

            @-webkit-keyframes loading {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @keyframes loading {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @media only screen and (max-width: 600px) {
                form {
                    width: 80vw;
                    min-width: initial;
                }
            }
        </style>
    @endpush

    <div class="py-12">
        <p class="mt-6 max-w-2xl text-xl text-gray-500 text-center mx-auto mb-12">
            You are about to subscribe to the <strong>{{ $plan_desc }}</strong> plan.
        </p>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Display a payment form -->
            <form id="payment-form" method="POST" action="{{ route('checkout') }}" class="mx-auto">

                @csrf
                <input type="hidden" name="plan" value="{{ $plan }}">
                <div id="payment-element">
                    <!--Stripe.js injects the Payment Element-->
                </div>
                <button id="btnSubmit" class="bg-gray-900 text-white px-4 py-2 rounded-xl">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Pay now</span>
                </button>
                <div id="payment-message" class="hidden"></div>
            </form>
        </div>
    </div>



    @push('scripts')
        <script>
            const stripe = Stripe('{{ env('STRIPE_KEY') }}');
            let elements;

            initialize();

            document
                .querySelector("#payment-form")
                .addEventListener("submit", handleSubmit);

            // Fetches a payment intent and captures the client secret
            function initialize() {
                const clientSecret = '{{ $intent->client_secret }}';

                elements = stripe.elements({
                    clientSecret
                });

                // const paymentElementOptions = {
                //     layout: "tabs",
                // };
                // const paymentElement = elements.create("payment", paymentElementOptions);
                const paymentElement = elements.create("payment");
                paymentElement.mount("#payment-element");
            }

            async function handleSubmit(e) {
                e.preventDefault();
                setLoading(true);

                const {
                    setupIntent,
                    error
                } = await stripe.confirmSetup({
                    elements,
                    confirmParams: {
                        // Make sure to change this to your payment completion page
                        return_url: "http://localhost:4242/checkout.html",
                    },
                    redirect: "if_required",
                });

                // This point will only be reached if there is an immediate error when
                // confirming the payment. Otherwise, your customer will be redirected to
                // your `return_url`. For some payment methods like iDEAL, your customer will
                // be redirected to an intermediate site first to authorize the payment, then
                // redirected to the `return_url`.
                if (error) {
                    if (error.type === "card_error" || error.type === "validation_error") {
                        showMessage(error.message);
                    } else {
                        showMessage("An unexpected error occurred.");
                    }
                } else {
                    // console.log('setupIntent', setupIntent);
                    var form = document.getElementById('payment-form');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'paymentMethod');
                    hiddenInput.setAttribute('value', setupIntent.payment_method);
                    form.appendChild(hiddenInput);
                    form.submit();
                }

                // setLoading(false);
            }


            // ------- UI helpers -------

            function showMessage(messageText) {
                const messageContainer = document.querySelector("#payment-message");

                messageContainer.classList.remove("hidden");
                messageContainer.textContent = messageText;

                setTimeout(function() {
                    messageContainer.classList.add("hidden");
                    messageContainer.textContent = "";
                }, 4000);
            }

            // Show a spinner on payment submission
            function setLoading(isLoading) {
                if (isLoading) {
                    // Disable the button and show a spinner
                    document.querySelector("#btnSubmit").disabled = true;
                    document.querySelector("#spinner").classList.remove("hidden");
                    document.querySelector("#button-text").classList.add("hidden");
                } else {
                    document.querySelector("#btnSubmit").disabled = false;
                    document.querySelector("#spinner").classList.add("hidden");
                    document.querySelector("#button-text").classList.remove("hidden");
                }
            }
            // const clientSecret = '{{ $intent->client_secret }}';
            // console.log('stripe', stripe);
            // const appearance = {
            //     theme: 'stripe',
            // };

            // const elements = stripe.elements({clientSecret, appearance});
            // const cardElement = elements.create('payment')

            // cardElement.mount('#card-element');

            // // const cardHolderName = document.getElementById('card-holder-name');
            // const cardButton = document.getElementById('card-button');
            // // const clientSecret = cardButton.dataset.secret;
            // console.log(cardElement.)

            // cardButton.addEventListener('click', async (e) => {

            //     const { setupIntent, error } = await stripe.confirmCardSetup(
            //         clientSecret, {
            //             payment_method: {
            //                 card: cardElement,
            //                 // billing_details: { name: cardHolderName.value }
            //             }
            //         }
            //     );

            //     if (error) {
            //         // Display "error.message" to the user...
            //         alert(error.message)
            //     } else {
            //         // The card has been verified successfully...
            //         alert('the card has been verified successfully')
            //     }
            // });
        </script>
    @endpush
</x-app-layout>
