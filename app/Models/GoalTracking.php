<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalTracking extends Model
{
    protected $fillable = [
        'branch',
        'goal_type',
        'start_date',
        'end_date',
        'subject',
        'target_achievement',
        'description',
        'created_by',
    ];

    public function goalType()
    {
        return $this->hasOne('App\Models\GoalType', 'id', 'goal_type');
    }

    public function branches()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch');
    }

    public static $status = [
        'Not Started',
        'In Progress',
        'Completed',
    ];
}
