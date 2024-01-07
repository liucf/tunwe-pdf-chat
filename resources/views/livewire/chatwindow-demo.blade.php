<div>
    <div class="pdfobject-container flex flex-col absolute top-0 lg:right-0 w-full lg:w-1/2  bg-[#faf9f6]">
        <div class="flex-1 overflow-y-scroll scroll-smooth" id="chat-feed">
            @foreach ($showMessages as $message)
                @if (json_decode($message)->role == 'user')
                    <div wire:key="{{ json_decode($message)->id }}" class="flex bg-white p-4 items-start">
                        <div>
                            <svg class="icon size-5" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5443" width="200" height="200">
                                <path d="M914.285714 802.857143q0 68.571429-41.714285 108.285714t-110.857143 39.714286H262.285714q-69.142857 0-110.857143-39.714286T109.714286 802.857143q0-30.285714 2-59.142857t8-62.285715T134.857143 619.428571t24.571428-55.714285 35.428572-46.285715 48.857143-30.571428T307.428571 475.428571q5.142857 0 24 12.285715t42.571429 27.428571 61.714286 27.428572T512 554.857143t76.285714-12.285714 61.714286-27.428572 42.571429-27.428571 24-12.285715q34.857143 0 63.714285 11.428572t48.857143 30.571428 35.428572 46.285715 24.571428 55.714285 15.142857 62 8 62.285715 2 59.142857z m-182.857143-510.285714q0 90.857143-64.285714 155.142857T512 512 356.857143 447.714286 292.571429 292.571429t64.285714-155.142858T512 73.142857t155.142857 64.285714T731.428571 292.571429z" p-id="5444" fill="#FF612E"></path>
                            </svg>
                        </div>
                        <div class="rounded-lg px-2">
                            {{ json_decode($message)->message }}
                        </div>
                    </div>
                @else
                    <div wire:key="{{ json_decode($message)->id }}" class="flex bg-gray-100 p-4  items-start">
                        <div>
                            {{-- <img src="/favicon.svg" alt="logo" class="size-5"> --}}
                            <svg stroke="currentColor" class="w-6 h-6" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1544">
                                <path d="M717.12 274H762c82.842 0 150 67.158 150 150v200c0 82.842-67.158 150-150 150H262c-82.842 0-150-67.158-150-150V424c0-82.842 67.158-150 150-150h44.88l-18.268-109.602c-4.086-24.514 12.476-47.7 36.99-51.786 24.514-4.086 47.7 12.476 51.786 36.99l20 120c0.246 1.472 0.416 2.94 0.516 4.398h228.192c0.1-1.46 0.27-2.926 0.516-4.398l20-120c4.086-24.514 27.272-41.076 51.786-36.99 24.514 4.086 41.076 27.272 36.99 51.786L717.12 274zM262 364c-33.138 0-60 26.862-60 60v200c0 33.138 26.862 60 60 60h500c33.138 0 60-26.862 60-60V424c0-33.138-26.862-60-60-60H262z m50 548c-24.852 0-45-20.148-45-45S287.148 822 312 822h400c24.852 0 45 20.148 45 45S736.852 912 712 912H312z m-4-428c0-24.852 20.148-45 45-45S398 459.148 398 484v40c0 24.852-20.148 45-45 45S308 548.852 308 524v-40z m318 0c0-24.852 20.148-45 45-45S716 459.148 716 484v40c0 24.852-20.148 45-45 45S626 548.852 626 524v-40z" fill="#1296db" p-id="1545"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="prose prose-p:my-0 px-2 flex-wrap max-w-full ">
                                {!! Str::of(json_decode($message)->message)->markdown() !!}
                            </div>

                            @if (count(json_decode($message)->chunks_id))
                                <div class="flex bg-gray-100 px-2 h-12">
                                    @foreach (json_decode($message)->chunks_id as $chunk)
                                        <div wire:key="{{ $chunk->id }}" class="inline-flex border rounded text-sm text-[rgba(0,0,0,0.8)] whitespace-nowrap transition-all duration-[0.2s] ease-[ease] delay-[0s] cursor-pointer ml-0 mr-3.5 my-[7px] px-[7px] py-[5px] border-solid border-[rgb(229,227,218)] bg-[#f8f5ee]">
                                            <button type="button" wire:click="$dispatch('search-chunk-button', { chunkid: {{ $chunk->id }} })"> P. {{ $chunk->page }}
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach

            @if ($loading)
                <div class="flex bg-gray-100 p-4  items-start">
                    <div>
                        <svg stroke="currentColor" class="w-6 h-6" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1544">
                            <path d="M717.12 274H762c82.842 0 150 67.158 150 150v200c0 82.842-67.158 150-150 150H262c-82.842 0-150-67.158-150-150V424c0-82.842 67.158-150 150-150h44.88l-18.268-109.602c-4.086-24.514 12.476-47.7 36.99-51.786 24.514-4.086 47.7 12.476 51.786 36.99l20 120c0.246 1.472 0.416 2.94 0.516 4.398h228.192c0.1-1.46 0.27-2.926 0.516-4.398l20-120c4.086-24.514 27.272-41.076 51.786-36.99 24.514 4.086 41.076 27.272 36.99 51.786L717.12 274zM262 364c-33.138 0-60 26.862-60 60v200c0 33.138 26.862 60 60 60h500c33.138 0 60-26.862 60-60V424c0-33.138-26.862-60-60-60H262z m50 548c-24.852 0-45-20.148-45-45S287.148 822 312 822h400c24.852 0 45 20.148 45 45S736.852 912 712 912H312z m-4-428c0-24.852 20.148-45 45-45S398 459.148 398 484v40c0 24.852-20.148 45-45 45S308 548.852 308 524v-40z m318 0c0-24.852 20.148-45 45-45S716 459.148 716 484v40c0 24.852-20.148 45-45 45S626 548.852 626 524v-40z" fill="#1296db" p-id="1545"></path>
                        </svg>
                    </div>
                    <div class="prose prose-p:my-0 px-2 flex-wrap max-w-full" wire:stream="answer">
                        {!! $answer !!}
                    </div>
                </div>
            @endif

            <div id="end-of-chat"></div>
        </div>

        <form wire:submit="submitQuestion;">
            <div class="w-full bg-purple-100 py-6 px-4 flex items-center">
                <input autofocus wire:model="question" class="w-full rounded-md pr-10" type="text" {{-- {{ $loading===false ? '' : 'disabled' }} --}} {{-- wire:loading.class="opacity-0 hidden" --}} {{-- wire:target="submitQuestion"  --}} placeholder="Enter your question (max 1,000 characters)">

                @if ($loading)
                    <div class="absolute right-12">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                @else
                    <button type="submit" class="size-4 absolute right-12">
                        <svg stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                @endif
            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            if (typeof interval !== 'undefined') {
                clearInterval(interval);
                let interval = null;
            }
            async function scrollDown() {
                setTimeout(() => {
                    var element = document.getElementById("end-of-chat");
                    element.scrollIntoView({
                        behavior: "instant"
                    });
                }, 100);
            }

            window.addEventListener('startScrollDown', async function(e) {
                await scrollDown();

                interval = setInterval(() => {
                    // console.log('scrolling');
                    var element = document.getElementById("end-of-chat");
                    element.scrollIntoView({
                        behavior: "smooth"
                    });
                }, 500);

            });

            window.addEventListener('endScrollDown', async function(e) {
                // console.log('endScrollDown');
                clearInterval(interval);
                await scrollDown();
            });
        </script>
    @endpush
</div>
