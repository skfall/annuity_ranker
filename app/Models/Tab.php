<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model {
    protected $table = 'osc_tabs';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function company() {
    	return $this->belongsTo('App\Models\Company');
    }
}
