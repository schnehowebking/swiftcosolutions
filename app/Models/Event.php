<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'employee_id',
        'title',
        'start_date',
        'end_date',
        'color',
        'description',
        'created_by',
    ];
}
