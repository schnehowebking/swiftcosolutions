<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractComment extends Model
{
    protected $fillable = [
        'contract_id',
        'user_id',
        'comment',
    ];

    public function employee()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}
