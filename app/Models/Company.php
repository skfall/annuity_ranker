<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    protected $table = 'osc_companies';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function rates() {
    	return $this->hasMany('App\Models\Rate');
    }

    public function tabs() {
    	return $this->hasMany('App\Models\Tab');
    }

    public function reviews() {
    	return $this->hasMany('App\Models\Review');
    }
}
