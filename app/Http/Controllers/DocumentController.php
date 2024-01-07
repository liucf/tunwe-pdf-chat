<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\PdfToText\Pdf;
use Symfony\Component\Process\Process;
use OpenAI\Laravel\Facades\OpenAI;

class DocumentController extends Controller
{

    public function index(): View
    {
        return view('documents.index');
    }


    public function store(): JsonResponse
    {
        Document::create([
            'title' => 'My Second Document',
            'slug' => 'my-second-document',
            'user_id' => 1,
        ]);

        return response()->json(["result" => "ok"], 200);
    }

    public function show(Document $document)
    {
        $pdfurl = asset('storage/' . $document->path);
        return view('documents.show')->with(compact('document', 'pdfurl'));
    }


    public function test()
    {

        $test = DB::collection('chunks')->get();

        dd($test);

        // $document = Document::take(1)->get()->first();

        // // $pdffile = 'pdf/Accelerating the XGBoost algorithm using GPU computing.pdf';
        // $pdffile = storage_path('app/' . $document->path);
        // // dd($pdffile);


        // $binInfoPath = '/opt/homebrew/bin/pdfinfo';

        // $command = "{$binInfoPath} '{$pdffile}' | grep 'Pages:' -";
        // $process = Process::fromShellCommandline($command);
        // $process->run();

        // $pages = trim($process->getOutput(), " \t\n\r\0\x0B\x0C");
        // $pages = trim(str_replace('Pages:', '', $pages));
        // // dd($pages);

        // for ($i = 1; $i <= $pages; $i++) {
        //     $text = Pdf::getText($pdffile, '/opt/homebrew/bin/pdftotext', ['f ' . $i, 'l ' . $i]);
        //     // chunking the text to 2000 characters
        //     $chunks = str_split($text, 2000);
        //     foreach ($chunks as $chunk) {
        //         $chunk = trim($chunk);
        //         //    get embedding of chunk from openai

        //         $response = OpenAI::Embeddings()->create([
        //             'model' => 'text-embedding-ada-002',
        //             'input' =>  $chunk,
        //         ]);
        //         $embedding = $response->embeddings[0]->embedding;
        //         // save chunk to database

        //         $document->chunks()->create([
        //             'page' => $i,
        //             'chunk' => $chunk,
        //             'chunk_embedding' => $embedding,
        //         ]);

        //         // dd($$document);
        //     }
        // }
        // echo Pdf::getText('pdf/Accelerating the XGBoost algorithm using GPU computing.pdf', '/opt/homebrew/bin/pdftotext', ['f 1', 'l 1']);
    }
}
