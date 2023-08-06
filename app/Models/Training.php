<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'branch',
        'trainer_option',
        'training_type',
        'trainer',
        'training_cost',
        'employee',
        'start_date',
        'end_date',
        'description',
        'created_by',
    ];


    public static $options = [
        'Internal',
        'External',
    ];

    public static $performance = [
        'Not Concluded',
        'Satisfactory',
        'Average',
        'Poor',
        'Excellent',
    ];

    public static $Status = [
        'Pending',
        'Started',
        'Completed',
        'Terminated',
    ];

    public function branches()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch');
    }

    public function types()
    {
        return $this->hasOne('App\Models\TrainingType', 'id', 'training_type');
    }

    public function employees()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee');
    }

    public function trainers()
    {
        return $this->hasOne('App\Models\Trainer', 'id', 'trainer');
    }
    public static function status($status)
    {
        if ($status == '0') {
            return 'Pending';
        }
        if ($status == '1') {
            return 'Started';
        }
        if ($status == "2") {
            return "Completed";
        }
        if ($status == "3") {
            return "Terminated";
        }
    }

    public static function save_training($request)
    {
        $saveData = Training::create([
            'title' => $request->title,
            'status_id' => $request->statusId,
            'user_id' => $request->userId,
            'training_code' => $request->trainingCode,
            'details' => $request->details,
            'meta_tags' => $request->metaTags,
            'duration' => $request->duration,
            'venue' => $request->venue,
            'discount' => $request->discount,
            'starts_at' => $request->startsAt,
            'ends_at' => $request->endsAt,
            'registration_deadline' => $request->registrationDeadline,
            'contact_phone_no' => $request->contactPhoneNo,
            'alternate_contact_phone' => $request->alternateContactPhone,
            'contact_email' => $request->contactEmail,
            'is_active' => $request->isActive,
        ]);
        if (!empty($saveData)) {
            $result = [
                'message' => 'training saved successfully.',
                'response' => 'success',
            ];
        } else {
            $result = [
                'message' => 'Failed.',
                'response' => 'error',
            ];
        }
        return $result;
    }

    public static function update_training($request, $training)
    {
        if (empty($training)) {
            $result = [
                'message' => 'Not found',
                'response' => 'error',
            ];
        }
        $updateData = $training->update([
            'title' => $request->title,
            'status_id' => $request->statusId,
            'user_id' => $request->userId,
            'training_code' => $request->trainingCode,
            'details' => $request->details,
            'meta_tags' => $request->metaTags,
            'duration' => $request->duration,
            'venue' => $request->venue,
            'discount' => $request->discount,
            'starts_at' => $request->startsAt,
            'ends_at' => $request->endsAt,
            'registration_deadline' => $request->registrationDeadline,
            'contact_phone_no' => $request->contactPhoneNo,
            'alternate_contact_phone' => $request->alternateContactPhone,
            'contact_email' => $request->contactEmail,
            'is_active' => $request->isActive,
        ]);
        if (!empty($updateData)) {
            $result = [
                'message' => 'training update successfully.',
                'response' => 'success',
            ];
        } else {
            $result = [
                'message' => 'Failed.',
                'response' => 'error',
            ];
        }
        return $result;
    }
}
