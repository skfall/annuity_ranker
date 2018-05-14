<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model {
    protected $table = 'osc_answers';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

      
    public function question() {
    	return $this->belongsTo('App\Models\Question');
    }
      
    public function userAnswers() {
    	return $this->hasMany('App\Models\UserAnswers');
  	}
}
