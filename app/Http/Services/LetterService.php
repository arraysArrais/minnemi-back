<?php

namespace App\Http\Services;

use App\Http\Requests\LetterRequest;
use App\Models\Letter;
use Carbon\Carbon;

class LetterService{
    public function InsertLetter(LetterRequest $r){
        return Letter::create($r->toArray());
    }

    public function RetrieveLettersToDispatch(){
        return Letter::all()->where('date_to_send', Carbon::now());
    }
}
