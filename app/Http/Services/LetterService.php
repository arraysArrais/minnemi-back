<?php

namespace App\Http\Services;

use App\Http\Requests\LetterRequest;
use App\Models\Letter;

class LetterService
{

    public function InsertLetter(LetterRequest $r)
    {
        $requestLetter = $r->only('title', 'content', 'date_to_send', 'received', 'read', 'recipient_email', 'user_id', 'visibility_id');

        $newLetter = Letter::create($requestLetter);

        return $newLetter;
    }
}
