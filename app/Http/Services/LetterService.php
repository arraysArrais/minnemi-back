<?php

namespace App\Http\Services;

use App\Http\Requests\LetterRequest;
use App\Models\Letter;

class LetterService{
    public function InsertLetter(LetterRequest $r){
        return Letter::create($r->toArray());
    }
}
