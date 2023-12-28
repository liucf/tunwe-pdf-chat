<div class="px-4 sm:px-6 lg:px-8" x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg max-w-xl mx-auto mt-32" @fileuploadedlist="modalOpen=false;">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Plans</h1>
            <p class="mt-2 text-sm text-gray-700">Your team is on the <strong class="font-semibold text-gray-900">Startup</strong> plan. The next payment of $80 will be due on August 4, 2022.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <button @click="modalOpen=true" type="button" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <!-- Heroicon name: mini/plus -->
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                {{ __('Upload') }}
            </button>
        </div>
    </div>

    <livewire:pages.documents.upload-document-form-filepond />
