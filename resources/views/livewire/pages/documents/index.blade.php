<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Reactive;
use App\Models\Document;
use Livewire\Attributes\On; 

new class extends Component {

    public $documentsCount = 0;

    public $query = "";

    public function mount()
    {
        $this->documentsCount = Document::count();
    }

    #[On('search')] 
    public function searchDocuments($query="")
    {
        $this->query = $query;
    }
};
?>

<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
              <x-document-message>
                    {{ __(session('status')) }}
              </x-document-message>
            @endif
   
          
            @if ($documentsCount == 0)
                <div>
                    <livewire:pages.documents.upload-document-form @fileuploaded="$refresh" />
                </div>
            @else
                <div>
                    <livewire:pages.documents.upload-document-form-to-list @fileuploaded="$refresh">
                    <livewire:documents :$query/>
                </div>
        </div>
        @endif

    </div>
</div>
</div>
