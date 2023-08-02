<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{

    protected $fillable = [
        'title',
        'user_id',
        'password',
        'start_date',
        'duration',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function getUserInfo()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function checkDateTime()
    {
        $m = $this;
        if (\Carbon\Carbon::parse($m->start_date)->addMinutes($m->duration)->gt(\Carbon\Carbon::now())) {
            return 1;
        } else {
            return 0;
        }
    }

    public function user_detail($userid = '0')
    {
        $return = '';
        if (!empty($userid)) {
            $user = User::whereraw('id IN (' . $userid . ')')->pluck('name')->toArray();
            if (!empty($user)) {
                $return = implode(',', $user);
            }
        }
        return $return;
    }

    public function users($users)
    {

        $userArr = explode(',', $users);
        $users  = [];
        foreach ($userArr as $user) {
            $users[] = User::find($user);
        }

        return $users;
    }
}
