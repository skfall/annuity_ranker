<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    protected $table = 'osc_projects';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function type() {
    	return $this->hasOne('App\Models\ProjectTypes', 'id', 'type');
    }
      
    public function stages() {
    	return $this->hasMany('App\Models\Stage', 'project_id');
  	}
}
