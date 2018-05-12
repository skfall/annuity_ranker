<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annuity extends Model {
    protected $table = 'osc_annuities';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
}
