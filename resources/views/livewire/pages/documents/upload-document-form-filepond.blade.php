<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Session;
use App\Events\DocumentCreated;

new class extends Component {
    use WithFileUploads;

    public $uploadedFile;

    public function uploadDocument()
    {
        $validated = $this->validate([
            'uploadedFile' => 'required|mimes:pdf',
        ]);

        $user = Auth::user();

        $document = $user->documents()->create([
            'name' => $validated['uploadedFile']->getClientOriginalName(),
            'path' => $validated['uploadedFile']->storeAs('documents', $validated['uploadedFile']->hashName(), 'public'),
            'size' => $validated['uploadedFile']->getSize(),
        ]);

        event(new DocumentCreated(($document)));

        Session::flash('status', 'Successfully uploaded');
        $this->dispatch('fileuploaded');
        return redirect()->to('/documents');
       
        // $this->dispatch('fileuploadedlist');
    }
}; ?>


<div>
    <template x-teleport="body">
        <div x-show="modalOpen" x-on:fileuploaded.window="pond.removeFiles()" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak x-data x-init="
            pond = FilePond.create($refs.input, {
                acceptedFileTypes: ['application/pdf'],
                maxFileSize: '10MB',
            });
            pond.setOptions({
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        @this.upload('uploadedFile', file, load, error, progress)
                    },
                    revert: (filename, load) => {
                        @this.removeUpload('uploadedFile', filename, load)
                    },
                }
            })">

            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 w-full h-full bg-white backdrop-blur-sm bg-opacity-70"></div>
            <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95" class="relative w-full py-6 bg-white border shadow-lg px-7 border-neutral-200 sm:max-w-lg sm:rounded-lg">
                <div class="flex items-center justify-between pb-3">
                    <h3 class="text-lg font-semibold">{{ __('Upload document') }}</h3>
                    <button @click="modalOpen=false" class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form wire:submit="uploadDocument">
                    <div class="relative w-auto pb-8" wire:ignore>
                        <div>
                            <input id="filepondinput" wire:model="uploadedFile" type="file" credits="false" x-ref="input" required />
                        </div>
                    </div>

                    <x-input-error class="mt-2" :messages="$errors->get('uploadedFile')" />

                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                        <button @click="modalOpen=false" type="button" class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors border rounded-md focus:outline-none focus:ring-2 focus:ring-neutral-100 focus:ring-offset-2">{{ __('Cancel') }}</button>
                        <button type="submit" class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 bg-neutral-950 hover:bg-neutral-900">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
