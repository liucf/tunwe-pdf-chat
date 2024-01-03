<x-app-layout>
    <div class="mx-auto max-w-7xl py-24 px-6 lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-4xl sm:leading-none lg:text-5xl text-center">Pricing plans</h2>
        {{-- <p class="mt-6 max-w-2xl text-xl text-gray-500">Choose an affordable plan that's packed with the best features for engaging your audience, creating customer loyalty, and driving sales.</p> --}}
      
        <!-- Tiers -->
        <div class="mt-24 space-y-12 lg:grid lg:grid-cols-3 lg:gap-x-8 lg:space-y-0">
          <div class="relative flex flex-col rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="flex-1">
              <h3 class="text-xl font-semibold text-gray-900">Free</h3>
              <p class="mt-4 flex items-baseline text-gray-900">
                <span class="text-5xl font-bold tracking-tight">$0</span>
                <span class="ml-1 text-xl font-semibold">/month</span>
              </p>
              <p class="mt-6 text-gray-500">Free forever</p>
      
              <!-- Feature list -->
              <ul role="list" class="mt-6 space-y-6">
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">1 documents</span>
                </li>
      
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">1000 questions</span>
                </li>
      
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">10MB File Size</span>
                </li>
      
             
              </ul>
            </div>
      
            <a href="#" class="bg-indigo-50 text-indigo-700 hover:bg-indigo-100 mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium">Monthly billing</a>
          </div>
      
          <div class="relative flex flex-col rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="flex-1">
              <h3 class="text-xl font-semibold text-gray-900">Monthly</h3>
      
              <p class="absolute top-0 -translate-y-1/2 transform rounded-full bg-indigo-500 py-1.5 px-4 text-sm font-semibold text-white">Most popular</p>
              <p class="mt-4 flex items-baseline text-gray-900">
                <span class="text-5xl font-bold tracking-tight">$9</span>
                <span class="ml-1 text-xl font-semibold">/month</span>
              </p>
              <p class="mt-6 text-gray-500">Access all features.</p>
      
              <!-- Feature list -->
              <ul role="list" class="mt-6 space-y-6">
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">Unlimited documents</span>
                </li>
      
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">Unlimited questions</span>
                </li>
      
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">50MB File Size</span>
                </li>
      
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">24-hour support response time</span>
                </li>
      
               
              </ul>
            </div>
      
            <a href="#" class="bg-indigo-500 text-white hover:bg-indigo-600 mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium">Monthly billing</a>
          </div>
      
          <div class="relative flex flex-col rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="flex-1">
              <h3 class="text-xl font-semibold text-gray-900">Annually</h3>
              <p class="mt-4 flex items-baseline text-gray-900">
                <span class="text-5xl font-bold tracking-tight">$89</span>
                <span class="ml-1 text-xl font-semibold">/year</span>
              </p>
              <p class="mt-6 text-gray-500">Access all features for one year.</p>
      
              <!-- Feature list -->
              <ul role="list" class="mt-6 space-y-6">
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">Unlimited documents</span>
                </li>
      
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">Unlimited questions</span>
                </li>
      
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">50MB File Size</span>
                </li>
      
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">24-hour support response time</span>
                </li>
      
                <li class="flex">
                  <!-- Heroicon name: outline/check -->
                  <svg class="h-6 w-6 flex-shrink-0 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  <span class="ml-3 text-gray-500">One year</span>
                </li>
      
              </ul>
            </div>
      
            <a href="#" class="bg-indigo-50 text-indigo-700 hover:bg-indigo-100 mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium">Annually billing</a>
          </div>
        </div>
    </div>      
</x-app-layout>
