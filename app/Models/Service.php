<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {
    protected $table = 'osc_services';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

}
