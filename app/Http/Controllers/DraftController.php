<?php

namespace App\Http\Controllers;

use App\Http\Requests\DraftRequest;
use App\Http\Services\DraftService;
use Illuminate\Http\Request;
use Throwable;

class DraftController extends Controller
{
    public function __construct(private DraftService $draftService)
    {
    }

    public function create(DraftRequest $r)
    {
        try {
            $draft = $this->draftService->insertDraft($r);

            if ($draft) {
                return response()->json($draft);
            }
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'internal error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
