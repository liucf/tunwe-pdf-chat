<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Reactive;


new class extends Component { 
    public $query;
    public function search()
    {
        $this->dispatch('search', query: $this->query);
    }
};
?>

<div class="w-full">
    <label for="search" class="sr-only">Search</label>
    <div class="relative">
      <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <!-- Heroicon name: mini/magnifying-glass -->
        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
        </svg>
      </div>
      <input 
      wire:model="query"  
      wire:keyup="search"
      id="search" name="search" class="block w-full rounded-md border border-gray-300 bg-white py-2.5 pl-10 pr-3 leading-5 placeholder-gray-500 focus:border-indigo-500 focus:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-base" placeholder="Search" type="search">
    </div>
  </div>