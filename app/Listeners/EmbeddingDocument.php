<?php

namespace App\Listeners;

use App\Events\DocumentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\Process\Process;
use Spatie\PdfToText\Pdf;
use OpenAI\Laravel\Facades\OpenAI;
// use Illuminate\Support\Facades\Process;

class EmbeddingDocument implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DocumentCreated $event): void
    {
        // $result = Process::run('node resources/js/server/runscript.js');

        // $nodejsoutput =  $result->output();

        $document = $event->document;
        $pdffile = storage_path('app/public/' . $document->path);
        // logger()->info($pdffile);
        $command = 'node resources/js/server/runscript.js ' . $pdffile;
        // logger()->info($command);
        $process = Process::fromShellCommandline($command);
        $process->run();

        $nodejsoutput = $process->getOutput();
        logger()->info($nodejsoutput);
        $pages = json_decode($nodejsoutput, true)['pages'];
        $chunks = json_decode($nodejsoutput, true)['chunks'];

        foreach ($chunks as $chunk) {
            $response = OpenAI::Embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' =>  $chunk['content'],
            ]);
            $embedding = $response->embeddings[0]->embedding;

            $document->chunks()->create([
                'page' => $chunk['page'],
                'chunk' => $chunk['content'],
                'chunk_embedding' => json_encode($embedding),
                // 'chunk_embedding' => $embedding,
            ]);
        }

        $document->update([
            'page_count' => $pages,
            'chunk_count' => $document->chunks()->count(),
            'embedded' => true,
        ]);

        // logger()->info('Document created', [
        //     'document' => $event->document->toArray(),
        // ]);

        // $binInfoPath = '/opt/homebrew/bin/pdfinfo';
        // $binPdfToTextPath = '/opt/homebrew/bin/pdftotext';

        // $document = $event->document;
        // $pdffile = storage_path('app/public/' . $document->path);

        // $command = "{$binInfoPath} '{$pdffile}' | grep 'Pages:' -";
        // $process = Process::fromShellCommandline($command);
        // $process->run();

        // $pages = trim($process->getOutput(), " \t\n\r\0\x0B\x0C");
        // $pages = trim(str_replace('Pages:', '', $pages));


        // // dd($pages);
        // for ($i = 1; $i <= $pages; $i++) {
        //     $text = Pdf::getText($pdffile, $binPdfToTextPath, ['f ' . $i, 'l ' . $i]);
        //     // chunking the text to 2000 characters
        //     $chunks = str_split($text, 1000);
        //     foreach ($chunks as $chunk) {
        //         $chunk = trim($chunk);
        //         $response = OpenAI::Embeddings()->create([
        //             'model' => 'text-embedding-ada-002',
        //             'input' =>  $chunk,
        //         ]);
        //         $embedding = $response->embeddings[0]->embedding;
        //         // logger()->info('Chunk', [
        //         //     'chunk' => $chunk,
        //         //     'embedding' => json_encode($embedding),
        //         // ]);
        //         $document->chunks()->create([
        //             'page' => $i,
        //             'chunk' => $chunk,
        //             'chunk_embedding' => json_encode($embedding),
        //         ]);
        //     }
        // }

        // $document->update([
        //     'page_count' => $pages,
        //     'chunk_count' => $document->chunks()->count(),
        //     'embedded' => true,
        // ]);
    }
}
