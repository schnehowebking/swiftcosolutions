<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementEmployee extends Model
{
    protected $fillable = [
        'announcement_id',
        'employee_id',
        'created_by',
    ];
}
