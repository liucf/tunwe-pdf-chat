<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function cancelSubscription(): void
    {
        auth()
            ->user()
            ->subscription('default')
            ->cancel();
        $this->redirect('/profile');
    }

    public function resume(): void
    {
        auth()
            ->user()
            ->subscription('default')
            ->resume();
        $this->redirect('/profile');
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Your Plan') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            @if (!auth()->user()->subscribed())
                <div class="space-y-4">
                    <div>{{ __('You are currently not subscribed to any plan.') }}</div>
                    <div>
                        <a href="{{ route('price') }}" wire:navigate>
                            <x-primary-button>{{ __('Subscribe') }}</x-primary-button>
                        </a>
                    </div>
                </div>
            @else
                @if (auth()->user()->subscription('default')->onGracePeriod())
                    <div class="my-4 space-y-4">
                        <div>{{ __('Your subscription of :plan plan has been cancelled.', ['plan' => '$9 monthly']) }}</div>
                        <div>
                            You can use the services until to {{ date('Y-m-d',Auth::user()->subscription('default')->asStripeSubscription()->current_period_end) }}.
                        </div>
                        <p>
                            If you want to resume your subscription, click the button below.
                        </p>
                        <div>
                            <a wire:click="resume">
                                <x-primary-button>{{ __('Resume Subscribe') }}</x-primary-button>
                            </a>
                        </div>
                    </div>
                @else
                    @if (auth()->user()->subscribedToPrice('price_1OULgeHFk0f5ieaWSmgNbwcC'))
                        <div class="my-4">
                            {{ __('You are currently subscribed to the :plan plan.', ['plan' => '$9 monthly']) }}
                            <div class="my-4">Next billing date is: {{ date('Y-m-d',Auth::user()->subscription('default')->asStripeSubscription()->current_period_end) }}</div>
                        </div>
                    @endif

                    @if (auth()->user()->subscribedToPrice('price_1OULh5HFk0f5ieaWUaxAgi89'))
                        <div class="my-4">{{ __('You are currently subscribed to the :plan plan.', ['plan' => '$89 yearly']) }}</div>

                        <div class="my-4">Next billing date is: {{ date('Y-m-d',Auth::user()->subscription('default')->asStripeSubscription()->current_period_end) }}</div>
                    @endif


                    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-cancel-subscription')">{{ __('Cancel Subscription') }}</x-danger-button>
                @endif
            @endif

        </p>
    </header>

    <x-modal name="confirm-cancel-subscription" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="cancelSubscription" class="p-6">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to cancel current subscription?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Once your subscription is cancelled, you can still use the service until the end of the billing period.
            </p>



            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Confirm Cancel') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
