<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanOption extends Model
{
    protected $fillable = [
        'name',
        'created_by',
    ];
}
