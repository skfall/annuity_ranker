<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model {
	const UPDATED_AT = 'modified';
	protected $table = 'osc_settings';
}
