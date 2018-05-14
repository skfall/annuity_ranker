<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model {
    protected $table = 'osc_rates';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function annuity() {
    	return $this->belongsTo('App\Models\Annuity');
    }
      
    public function company() {
    	return $this->belongsTo('App\Models\Company');
    }
}
