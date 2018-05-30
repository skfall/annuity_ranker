<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model {
    protected $table = 'osc_nav';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function meta() {
    	return $this->hasOne('App\Models\Meta', 'alias', 'alias');
  	}
}
