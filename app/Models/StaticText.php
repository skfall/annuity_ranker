<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticText extends Model {
    protected $table = 'osc_static_texts';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
}
