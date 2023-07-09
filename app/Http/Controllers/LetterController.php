<?php

namespace App\Http\Controllers;

use App\Http\Requests\LetterRequest;
use App\Http\Services\LetterService;
use Throwable;

class LetterController extends Controller
{

    public function __construct(private LetterService $letterService)
    {
    }

        /**
     * @OA\Post(
     *     path="/api/letter/",
     *     security={{"bearerAuth": {}}},
     *     operationId="createLetter",
     *     tags={"Letter"},
     *     summary="create a Letter record in the database",
     *     @OA\Parameter(
     *         name="lang",
     *         in="header",
     *         description="The language of validation messages sent in responses. If no value is provided, it will use 'en' by default.",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"en", "pt"}
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *      type="object",
     *      @OA\Property(property="title", type="string", example="Letter #02"),
     *      @OA\Property(property="content", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempus et est eget convallis. Nullam eu tempor est. Nullam congue nulla eu eros fermentum, dictum varius neque varius. Integer euismod augue sit amet justo aliquet, a dapibus nibh volutpat. Duis sodales, orci sit amet pretium rutrum, leo ligula vestibulum ante"),
     *      @OA\Property(property="date_to_send", type="string", example="2025-06-04"),
     *      @OA\Property(property="received", type="number", example=1),
     *      @OA\Property(property="read", type="number", example=0),
     *      @OA\Property(property="recipient_email", type="string", example="teste@teste.com"),
     *      @OA\Property(property="user_id", type="number", example=1),
     *      @OA\Property(property="visibility_id", type="number", example=2),
     *   ),
     * ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *      type="object",
     *      @OA\Property(property="title", type="string", example="Letter #02"),
     *      @OA\Property(property="content", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempus et est eget convallis. Nullam eu tempor est. Nullam congue nulla eu eros fermentum, dictum varius neque varius. Integer euismod augue sit amet justo aliquet, a dapibus nibh volutpat. Duis sodales, orci sit amet pretium rutrum, leo ligula vestibulum ante"),
     *      @OA\Property(property="date_to_send", type="string", example="2025-06-04"),
     *      @OA\Property(property="received", type="number", example=1),
     *      @OA\Property(property="read", type="number", example=0),
     *      @OA\Property(property="recipient_email", type="string", example="teste@teste.com"),
     *      @OA\Property(property="user_id", type="number", example=1),
     *      @OA\Property(property="visibility_id", type="number", example=2),
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

    public function dispatch(){
            try{
                return $this->letterService->RetrieveLettersToDispatch();
            }
            catch(Throwable $e){
                return response()->json([
                    'error' => 'Internal error',
                    'message' => $e->getMessage()
                ], 500);
            }
             
    }
}

   