<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    protected $table = 'osc_questions';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function answers() {
    	return $this->hasMany('App\Models\Answer');
    }
      
    public function annuity() {
    	return $this->belongsTo('App\Models\Annuity');
    }
      
    public function userAnswers() {
    	return $this->hasMany('App\Models\UserAnswers');
  	}
}
