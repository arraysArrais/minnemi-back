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


    /**
     * @OA\Post(
     *     path="/api/draft/",
     *     security={{"bearerAuth": {}}},
     *     operationId="create",
     *     tags={"Draft"},
     *     summary="create a draft record in the database",
     *     
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *      type="object",
     *      @OA\Property(property="title", type="string", example="Letter #02"),
     *      @OA\Property(property="content", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempus et est eget convallis. Nullam eu tempor est. Nullam congue nulla eu eros fermentum, dictum varius neque varius. Integer euismod augue sit amet justo aliquet, a dapibus nibh volutpat. Duis sodales, orci sit amet pretium rutrum, leo ligula vestibulum ante"),
     *      @OA\Property(property="user_id", type="number", example=1),
     *   ),
     * ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *      type="object",
     *      @OA\Property(property="title", type="string", example="Letter #02"),
     *      @OA\Property(property="content", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempus et est eget convallis. Nullam eu tempor est. Nullam congue nulla eu eros fermentum, dictum varius neque varius. Integer euismod augue sit amet justo aliquet, a dapibus nibh volutpat. Duis sodales, orci sit amet pretium rutrum, leo ligula vestibulum ante"),
     *      @OA\Property(property="user_id", type="number", example=1),
     *      @OA\Property(property="created_at", type="string", example="2023-06-25T17:56:59.000000Z"),
     *      @OA\Property(property="updated_at", type="string", example="2023-06-25T17:56:59.000000Z"),
     *      @OA\Property(property="id", type="number", example=2),
     *   ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unathenticated", 
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid data"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error while fetching data in database"
     *     ),
     * ),
     */
    public function create(DraftRequest $r)
    {
        try {
            $draft = $this->draftService->insertDraft($r);

            if ($draft) {
                return response()->json($draft, 201);
            }
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'internal error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
