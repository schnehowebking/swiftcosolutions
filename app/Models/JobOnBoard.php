<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOnBoard extends Model
{
    protected $fillable = [
        'application',
        'joining_date',
        'job_type',
        'days_of_week',
        'salary',
        'salary_type',
        'salary_duration',
        'status',
        'convert_to_employee',
        'created_by',
        'created_at',
        'updated_at',

    ];

    public function applications()
    {
        return $this->hasOne('App\Models\JobApplication', 'id', 'application');
    }

    public static $status = [
        '' => 'Select Status',
        'pending' => 'Pending',
        'cancel' => 'Cancel',
        'confirm' => 'Confirm',
    ];
    public static $job_type = [
        '' => 'Select Job Type',
        'full time' => 'Full Time',
        'part time' => 'Part Time',
        
    ];
    public static $salary_duration = [
        '' => 'Select Salary Duration',
        'monthly' => 'Monthly',
        'weekly' => 'Weekly',
        
    ];
   
}
