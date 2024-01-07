<div class="relative" id="home">
    <div aria-hidden="true" class="absolute inset-0 grid grid-cols-2 -space-x-52 opacity-40 dark:opacity-20">
        <div class="blur-[106px] h-56 bg-gradient-to-br from-primary to-purple-400 dark:from-blue-700"></div>
        <div class="blur-[106px] h-32 bg-gradient-to-r from-cyan-400 to-sky-300 dark:to-indigo-600"></div>
    </div>
    <x-container>

        <div class="relative pt-36 ml-auto">
            <div class="lg:w-2/3 text-center mx-auto">
                <h1 class="text-gray-900 dark:text-white font-bold text-5xl md:text-6xl xl:text-7xl text-balance"> {{ __('home.chat') }}<span class="text-primary">AI</span></h1>
                <p class="mt-8 text-gray-700 dark:text-gray-300 text-balance">
                    {{ __('home.description') }}
                </p>
                <div class="mt-16 flex flex-wrap justify-center gap-y-4 gap-x-6">
                    <a href="{{ route('documents') }}" wire:navigate class="relative flex h-11 w-full items-center justify-center px-6 before:absolute before:inset-0 before:rounded-full before:bg-primary before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max">
                        <span class="relative text-base font-semibold text-white">
                            {{ __('home.start') }}
                        </span>
                    </a>
                    <a href="{{ route('demo') }}" wire:navigate class="relative flex h-11 w-full items-center justify-center px-6 before:absolute before:inset-0 before:rounded-full before:border before:border-transparent before:bg-primary/10 before:bg-gradient-to-b before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 dark:before:border-gray-700 dark:before:bg-gray-800 sm:w-max">
                        <span class="relative text-base font-semibold text-primary dark:text-white">{{ __('home.demo') }}</span>
                    </a>
                </div>
                <div class="hidden py-8 mt-16 border-y border-gray-100 dark:border-gray-800 sm:flex justify-between space-x-6 *:flex-1">
                    <div class="text-left">
                        <h6 class="text-lg font-semibold text-gray-700 dark:text-white">{{ __('home.upload') }}</h6>
                        <p class="mt-2 text-gray-500">{{ __('home.upload_desc') }}</p>
                    </div>
                    <div class="text-left">
                        <h6 class="text-lg font-semibold text-gray-700 dark:text-white">{{ __('home.answer') }}</h6>
                        <p class="mt-2 text-gray-500">{{ __('home.answer_desc') }}</p>
                    </div>
                    <div class="text-left">
                        <h6 class="text-lg font-semibold text-gray-700 dark:text-white">{{ __('home.source') }}</h6>
                        <p class="mt-2 text-gray-500">{{ __('home.source_desc') }}</p>
                    </div>
                </div>
            </div>
            {{-- <div class="mt-12 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6">
                <div class="p-4 grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/microsoft.svg" class="h-12 w-auto mx-auto" loading="lazy" alt="client logo" width="" height="" />
                </div>
                <div class="p-4 grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/airbnb.svg" class="h-12 w-auto mx-auto" loading="lazy" alt="client logo" width="" height="" />
                </div>
                <div class="p-4 flex grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/google.svg" class="h-9 w-auto m-auto" loading="lazy" alt="client logo" width="" height="" />
                </div>
                <div class="p-4 grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/ge.svg" class="h-12 w-auto mx-auto" loading="lazy" alt="client logo" width="" height="" />
                </div>
                <div class="p-4 flex grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/netflix.svg" class="h-8 w-auto m-auto" loading="lazy" alt="client logo" width="" height="" />
                </div>
                <div class="p-4 grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/google-cloud.svg" class="h-12 w-auto mx-auto" loading="lazy" alt="client logo" width="" height="" />
                </div>
            </div> --}}
        </div>
    </x-container>
</div>
