<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model {
    protected $table = 'osc_user_activity';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
}
