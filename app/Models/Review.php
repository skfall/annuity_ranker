<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    protected $table = 'osc_reviews';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function company() {
    	return $this->belongsTo('App\Models\Company');
    }
}
