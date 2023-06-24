<?php 

namespace App\Http\Services;

use App\Models\Draft;
use Illuminate\Http\Request;

class DraftService{
    public function insertDraft(Request $r){
        $draft = Draft::create($r);
        return $draft;
    }
}