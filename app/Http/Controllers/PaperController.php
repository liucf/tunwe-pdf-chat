<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaperController extends Controller
{

    public function index(): View
    {
        $papers = Paper::all();

        return view('documents', compact('papers'));
    }

    public function store(): JsonResponse
    {
        Paper::create([
            'title' => 'My Second Document',
            'slug' => 'my-second-document',
            'user_id' => 1,
        ]);

        return response()->json(["result" => "ok"], 200);
    }
}
