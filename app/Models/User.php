<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'osc_users';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function card() {
    	return $this->hasOne('App\Models\UserCard', 'id');
  	}
    
    public function comments() {
    	return $this->hasMany('App\Models\Comment', 'user_id');
  	}
}
