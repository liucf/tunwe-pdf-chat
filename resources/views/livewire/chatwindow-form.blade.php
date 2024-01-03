<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use Livewire\Attributes\Modelable;

new class extends Component
{
     #[Modelable]
    public $value = '';
    
    public function submitQuestion()
    {
        $this->dispatch('submit-question'); 
    }
}; ?>

{{-- <form wire:submit="submitQuestion;"> --}}
<form wire:submit="$dispatch('submit-question')">
    <div  class="w-full bg-purple-100 py-6 px-4 flex items-center">
        <input
        autofocus
        wire:model="value" 
        class="w-full rounded-md pr-10" 
        type="text" 
        wire:loading.class="opacity-0"
        wire:target="submitQuestion" 
        placeholder="Enter your question (max 1,000 characters)">
        
        <div wire:loading wire:target="submitQuestion" class="absolute right-12"> 
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
        </div>

        <button wire:target="submitQuestion"  wire:loading.remove type="submit" class="size-4 absolute right-12">
            <svg stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
        </button>
    </div>
</form>