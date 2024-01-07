<?php

namespace App\Livewire;

use App\Models\Chunk;
use App\Service\QueryEmbedding;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ChatwindowDemo extends Component
{
    public $document;
    public $messages = [];
    public $showMessages = [];
    public $question = "";
    public $answer = "";
    public $loading = false;
    protected QueryEmbedding $query;


    public function mount()
    {
        $this->messages[] = [
            'role' => 'system',
            'content' => 'You are a helpful assistant with limited access to info and designed to answer questions ONLY from the given document content else say that you don\'t know the answer and always answer the queries in the language they are asked in. If the "QUESTION" is in English, answer in English. If the "QUESTION" is in Spanish, answer in Spanish and similarly if the "QUESTION" is in XYZ language, answer it in the same XYZ language. Be as accurate as possible in providing answers only from the given document context. **Provide an answer that is STRICTLY relevant to the given context and must not include information from outside sources. You should answer only if the relevant info is provided in the CONTENT fields else say, I\'m sorry.**'
        ];
    }

    public function render()
    {
        return view('livewire.chatwindow-demo');
    }

    #[On('get-answer')]
    public function updateAnswer($question)
    {
        $contextData = $this->getContext($question);

        $context = json_decode($contextData)->context;
        $chunkData = json_decode($contextData)->chunkData;

        $chunkids = collect($chunkData)->map(function ($item) {
            return collect([
                'page' => $item->page,
                'id' => $item->id
            ]);
        })->toArray();

        $stream = $this->query->askQuestionStreamed($context, $question, $this->messages);

        $resultText = "";
        foreach ($stream as $response) {
            $text = $response->choices[0]->delta->content;
            $resultText .= $text;
            if (connection_aborted()) {
                break;
            }
            // $this->dispatch('scrollDown');
            $this->stream(to: 'answer', content: $text);
        }

        // $message = Message::create([
        //     'user_id' => auth()->id(),
        //     'document_id' => $this->document->id,
        //     'message' => $resultText,
        //     'role' => 'assistant',
        //     'chunks_id' => $chunkids
        // ]);

        // $this->showMessages[] = collect([
        //     'message' => $this->question,
        //     'role' => 'user',
        //     'id' => (string) Str::uuid()
        // ]);

        $this->showMessages[] = collect([
            'document_id' => $this->document->id,
            'message' => $resultText,
            'role' => 'assistant',
            'id' => (string) Str::uuid(),
            'chunks_id' => $chunkids
        ]);

        $this->dispatch('endScrollDown');
        $this->loading = false;
    }


    #[On('search-chunk-button')]
    public function searchChunk($chunkid)
    {
        logger($chunkid);
        $chunk = Chunk::find($chunkid);
        $search_text = $chunk->chunk;
        // get first 20 characters
        // $search_text = substr($search_text, 0, 20);
        logger($search_text);
        $this->dispatch('search-chunk', text: $search_text);
    }


    protected function getContext($question)
    {
        $this->query = new QueryEmbedding();

        $queryVectors = $this->query->getQueryEmbedding($question);
        $questionvector = json_encode($queryVectors);

        // 1 - (embedding <=> '$questionvector') AS cosine_similarity

        $result = DB::table('chunks')
            ->select("chunk", "id", "page")
            // ->selectRaw("chunk_embedding <=> '{$questionvector}'::vector AS cosine_similarity")
            ->selectSub("chunk_embedding <=> '{$questionvector}'::vector", "distance")
            ->where('document_id', $this->document->id)
            ->orderBy('distance', 'asc')
            ->limit(3)
            ->get();
        // only get distance <0.2
        $result = $result->filter(function ($item) {
            return $item->distance < 0.2;
        })->values();
        // logger($result);
        $chunkData = [];
        $chunkDataIndex = 0;
        $context = collect($result)->map(function ($item) use (&$chunkData, &$chunkDataIndex) {
            // $chunkData[$chunkDataIndex]['chunk'] = $item->chunk;
            $chunkData[$chunkDataIndex]['page'] = $item->page;
            $chunkData[$chunkDataIndex]['id'] = $item->id;
            $chunkDataIndex++;
            return $item->chunk;
        })->implode("\n\nContent: ");

        // return $context;
        // return a json string
        return json_encode([
            'context' => $context,
            'chunkData' => $chunkData
        ]);
    }

    #[On('submit-question')]
    public function submitQuestion()
    {

        if (trim($this->question) == "" || $this->loading) {
            return;
        }
        $this->loading = true;


        $this->showMessages[] = collect([
            'message' => $this->question,
            'role' => 'user',
            'id' => (string) Str::uuid()
        ]);

        // dd($this->showMessages);
        $this->dispatch('startScrollDown');

        $this->dispatch('get-answer', question: $this->question);
        $this->question = "";
    }
}
