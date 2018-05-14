<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswers extends Model {
    protected $table = 'osc_user_answers';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function question() {
    	return $this->belongsTo('App\Models\Question');
    }
      
    public function answer() {
    	return $this->belongsTo('App\Models\Answer');
    }
}
