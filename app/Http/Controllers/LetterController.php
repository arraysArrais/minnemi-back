<?php

namespace App\Http\Controllers;

use App\Http\Requests\LetterRequest;
use App\Http\Services\LetterService;
use App\Models\Letter;
use Throwable;

class LetterController extends Controller
{

    public function __construct(private LetterService $letterService)
    {
    }

    public function create(LetterRequest $r)
    {
        try {
            $letter = $this->letterService->InsertLetter($r);

            if ($letter) {
                return response()->json($letter, 201);
            }
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Internal error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
