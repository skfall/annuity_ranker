<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annuity extends Model {
    protected $table = 'osc_annuities';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function questions() {
    	return $this->hasMany('App\Models\Question');
    }
      
    public function rates() {
    	return $this->hasMany('App\Models\Rate');
    }
}
