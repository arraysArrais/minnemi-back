<?php

namespace App\Http\Services;

use App\Mail\LetterMail;
use App\Models\Letter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MailService{
    public function SendMail(){
        $letters = $this->RetrieveLettersToDispatch();

        foreach($letters as $letter){
            Mail::to($letter->recipient_email)->send(new LetterMail($letter));
        }
    }

    public function RetrieveLettersToDispatch(){
        return Letter::all()->where('date_to_send', Carbon::now()->format('Y-m-d'));
    }
}
