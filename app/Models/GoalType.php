<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalType extends Model
{
    protected $fillable = [
        'name',
        'created_by',
    ];
}
