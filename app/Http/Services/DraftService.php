<?php 

namespace App\Http\Services;

use App\Http\Requests\DraftRequest;
use App\Models\Draft;

class DraftService{
    public function insertDraft(DraftRequest $r){
        $draft = Draft::create($r->toArray());
        return $draft;
    }
}