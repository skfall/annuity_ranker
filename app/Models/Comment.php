<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    protected $table = 'osc_comments';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function stage() {
        return $this->belongsTo('App\Models\Stage', 'stage_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
