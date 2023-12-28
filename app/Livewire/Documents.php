<?php

namespace App\Livewire;

use Livewire\Component;

class Documents extends Component
{

    public function render()
    {
        $documents = auth()->user()->documents->sortByDesc('created_at');
        return view('livewire.pages.documents.index')->with(compact('documents'));
    }
}
