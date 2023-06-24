<?php

namespace App\Http\Services;

use App\Http\Requests\DraftRequest;
use App\Models\Draft;

class DraftService{
    public function insertDraft(DraftRequest $r){
        return Draft::create($r->toArray());
    }
}
