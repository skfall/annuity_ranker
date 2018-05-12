<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StageDoc extends Model {
    protected $table = 'osc_stage_docs';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function stage() {
        return $this->belongsTo('App\Models\Stage', 'stage_id', 'id');
    }
}
