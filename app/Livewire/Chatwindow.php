<?php

namespace App\Livewire;

use App\Models\Chunk;
use App\Models\Message;
use App\Service\QueryEmbedding;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;

class Chatwindow extends Component
{
    public $document;
    public $messages = [];
    public $showMessages = [];
    public $question = "";
    public $answer = "";
    public $reference = [];
    public $referenceChunk = [];

    public $loading = false;

    protected QueryEmbedding $query;

    public function mount()
    {
        // first element of messages to a json
        $this->messages[] = [
            'role' => 'system',
            'content' => 'You are a helpful assistant with limited access to info and designed to answer questions ONLY from the given document content else say that you don\'t know the answer and always answer the queries in the language they are asked in. If the "QUESTION" is in English, answer in English. If the "QUESTION" is in Spanish, answer in Spanish and similarly if the "QUESTION" is in XYZ language, answer it in the same XYZ language. Be as accurate as possible in providing answers only from the given document context. **Provide an answer that is STRICTLY relevant to the given context and must not include information from outside sources. You should answer only if the relevant info is provided in the CONTENT fields else say, I\'m sorry.**'
        ];

        $history = Message::where('document_id', $this->document->id)
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'asc')->get();
        foreach ($history as $message) {
            $this->showMessages[] = $message;
        }
    }

    public function render()
    {
        return view('livewire.chatwindow');
    }

    #[On('get-answer')]
    public function updateAnswer($question)
    {
        $contextData = $this->getContext($question);

        $context = json_decode($contextData)->context;
        $chunkData = json_decode($contextData)->chunkData;
        // logger($chunkData);


        $chunkids = collect($chunkData)->map(function ($item) {
            return $item->id;
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

        $message = Message::create([
            'user_id' => auth()->id(),
            'document_id' => $this->document->id,
            'message' => $resultText,
            'role' => 'assistant',
            'chunks_id' => $chunkids
        ]);
        $this->showMessages[] = $message;
        $this->dispatch('endScrollDown');
        $this->loading = false;
    }


    #[On('search-chunk-button')]
    public function searchChunk($chunkid)
    {
        $chunk = Chunk::find($chunkid);
        $search_text = $chunk->chunk;
        // get first 20 characters
        // $search_text = substr($search_text, 0, 20);
        $this->dispatch('search-chunk', text: $search_text);
    }


    protected function getContext($question)
    {
        $this->query = new QueryEmbedding();

        $queryVectors = $this->query->getQueryEmbedding($question);
        $questionvector = json_encode($queryVectors);

        // 1 - (embedding <=> '$questionvector') AS cosine_similarity

        $result = DB::table('chunks')
            ->select("chunk", "id")
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
            // $chunkData[$chunkDataIndex]['page'] = $item->page;
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
        // if the user's messages is more than 10 ,then return
        if (
            !auth()->user()->subscribed() &&
            count(auth()->user()->messagesOfUser) > 10
        ) {
            Session::flash('status', 'You have reached the limit of 10 questions. Please upgrade your plan.');
            return redirect()->route('price');
        }

        if (trim($this->question) == "" || $this->loading) {
            return;
        }
        $this->loading = true;
        $message = Message::create([
            'user_id' => auth()->id(),
            'document_id' => $this->document->id,
            'message' => $this->question,
            'role' => 'user',
        ]);

        $this->showMessages[] = $message;
        $this->dispatch('startScrollDown');

        $this->dispatch('get-answer', question: $this->question);
        $this->question = "";
    }
}
