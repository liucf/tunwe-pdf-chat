<?php

namespace App\Livewire;

use App\Models\Document;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;

class Documents extends Component
{
    use WithPagination;

    #[Reactive]
    public $query;

    public function render()
    {
        $documents = Document::where('user_id', auth()->user()->id)
            ->where('name', 'like', '%' . $this->query . '%')
            ->orderByDesc('created_at')
            ->paginate(10);
        $hasEmbedding = $documents->filter(function ($document) {
            return !$document->embedded;
        })->count() > 0;
        return view('livewire.pages.documents.list', compact('documents', 'hasEmbedding'));
    }

    public function delete($id)
    {
        $document = Document::findOrFail($id);

        Storage::disk('public')->delete($document->path);
        $document->delete();

        Session::flash('status', 'Successfully deleted');
        $this->dispatch('filedeleted');
        return redirect()->to('/documents');
    }
}
