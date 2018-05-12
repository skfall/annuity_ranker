<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model {
    protected $table = 'osc_stages';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function project() {
        return $this->belongsTo('App\Models\Project', 'project_id', 'id');
    }

    public function comments() {
    	return $this->hasMany('App\Models\Comment', 'stage_id');
    }
      
    public function photos() {
    	return $this->hasMany('App\Models\StagePhoto', 'stage_id');
  	}
    
    public function docs() {
    	return $this->hasMany('App\Models\StageDoc', 'stage_id');
  	}
}
