<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'requirement',
        'branch',
        'category',
        'skill',
        'position',
        'start_date',
        'end_date',
        'status',
        'applicant',
        'visibility',
        'code',
        'custom_question',
        'created_by',
    ];

    public static $status = [
        'active' => 'Active',
        'in_active' => 'In Active',
    ];

    public function branches()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch');
    }

    public function categories()
    {
        return $this->hasOne('App\Models\JobCategory', 'id', 'category');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function questions()
    {
        $ids = explode(',', $this->custom_question);

        return CustomQuestion::whereIn('id', $ids)->get();
    }

    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public static function save_job($request)
    {
        $saveData = Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'requirement' => $request->requirement,
            'company_id' => $request->companyId,
            'meta_tags' => $request->metaTags,
            'job_category_id' => $request->jobCategoryId,
            'responsibilities' => $request->responsibilities,
            'job_location' => $request->jobLocation,
            'total_vacancy' => $request->totalVacancy,
            'application_deadline' => $request->applicationDeadline,
            'salary_range' => $request->salaryRange,
            'min_experience' => $request->minExperience,
            'max_experience' => $request->maxExperience,
            'min_age' => $request->minAge,
            'max_age' => $request->maxAge,
            'preferred_gender' => $request->preferredGender,
            'requirements' => $request->requirements,
            'other_benefits' => $request->otherBenefits,
            'special_instruction' => $request->specialInstruction,
        ]);
        if (!empty($saveData)) {
            $result = [
                'message' => 'Job saved successfully.',
                'response' => 'success',
            ];
        } else {
            $result = [
                'response' => 'error',
                'message' => 'Failed.',
            ];
        }
        return $result;
    }

    public static function update_job($request, $job)
    {
        if (empty($job)) {
            $result = [
                'message' => 'Not found',
                'response' => 'error',
            ];
        }
        $updateData = $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'status_id' => $request->statusId,
            'company_id' => $request->companyId,
            'meta_tags' => $request->metaTags,
            'job_category_id' => $request->jobCategoryId,
            'responsibilities' => $request->responsibilities,
            'job_location' => $request->jobLocation,
            'total_vacancy' => $request->totalVacancy,
            'application_deadline' => $request->applicationDeadline,
            'salary_range' => $request->salaryRange,
            'min_experience' => $request->minExperience,
            'max_experience' => $request->maxExperience,
            'min_age' => $request->minAge,
            'max_age' => $request->maxAge,
            'preferred_gender' => $request->preferredGender,
            'requirements' => $request->requirements,
            'other_benefits' => $request->otherBenefits,
            'special_instruction' => $request->specialInstruction,
        ]);
        if (!empty($updateData)) {
            $result = [
                'message' => 'Job update successfully.',
                'response' => 'success',
            ];
        } else {
            $result = [
                'response' => 'error',
                'message' => 'Failed.',
            ];
        }
        return $result;
    }
}
