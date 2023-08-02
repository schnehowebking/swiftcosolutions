<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Invoice;
use App\Mail\UserCreate;
use App\Models\Notification;
use App\Models\User;
use App\Models\Utility;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage User'))
        {
            $user = \Auth::user();
            if(\Auth::user()->type == 'super admin')
            {
                $users = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'company')->get();
            }
            else
            {
                $users = User::where('created_by', '=', $user->creatorId())->where('type', '!=', 'employee')->get();
            }

            return view('user.index', compact('users'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function create()
    {
        if(\Auth::user()->can('Create User'))
        {
            $user  = \Auth::user();
            $roles = Role::where('created_by', '=', $user->creatorId())->where('name', '!=', 'employee')->get()->pluck('name', 'id');

            return view('user.create', compact('roles'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create User'))
        {
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->first();
            $validator        = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                                   'email' => 'required|unique:users',
                                   'password' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $role_r = Role::findById($request->role);
            $date = date("Y-m-d H:i:s");
            
            $user   = User::create(
                [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'type' => $role_r->name,
                    'lang' => !empty($default_language) ? $default_language->value : '',
                    'created_by' => \Auth::user()->id,
                    'email_verified_at' => $date,
                ]
            );
            $user->assignRole($role_r);
            $user->userDefaultData();

            $setings = Utility::settings();
            if($setings['new_user'] == 1)
            {

                $uArr = [
                    'email' => $user->email,
                    'password' => $request->password,
                ];
    
                $resp = Utility::sendEmailTemplate('new_user', [$user->id => $user->email], $uArr);
                return redirect()->route('user.index')->with('success', __('User successfully created.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

            }
            return redirect()->route('user.index')->with('success', __('User successfully created.'));


        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function show(User $user)
    {
        return view('profile.index');
    }

    public function edit($id)
    {
        if(\Auth::user()->can('Edit User'))
        {
            $user  = User::find($id);
            $roles = Role::where('created_by', '=', $user->creatorId())->where('name', '!=', 'employee')->get()->pluck('name', 'id');

            return view('user.edit', compact('user', 'roles'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required',
                               'email' => 'unique:users,email,' . $id,
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        if(\Auth::user()->can('Edit User'))
        {
            $user = User::findOrFail($id);

            $role          = Role::findById($request->role);
            $input         = $request->all();
            $input['type'] = $role->name;
            $user->fill($input)->save();

            $user->assignRole($role);

            return redirect()->route('user.index')->with('success', 'User successfully updated.');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function destroy($id)
        {
            if (\Auth::user()->can('Delete User')) {
                $user = User::findOrFail($id);
                $user->delete();

                return redirect()->route('user.index')->with('success', 'User successfully deleted.');
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }

    public function userPassword($id)
    { 
        $eId        = \Crypt::decrypt($id);
        
        $user = User::find($eId);
        
        $employee = User::where('id', $eId)->first();
        
        return view('user.reset', compact('user', 'employee'));
    }

    public function userPasswordReset(Request $request, $id){
        $validator = \Validator::make(
            $request->all(), [
                               'password' => 'required|confirmed|same:password_confirmation',
                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }


        $user                 = User::where('id', $id)->first();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return redirect()->route('user.index')->with(
                     'success', 'User Password successfully updated.'
                 );

    }

    public function profile()
    {
        $userDetail = \Auth::user();

        return view('user.profile')->with('userDetail', $userDetail);
    }

    public function editprofile(Request $request)
    {
        $userDetail = \Auth::user();
        $user       = User::findOrFail($userDetail['id']);

        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|max:120',
                               'email' => 'required|email|unique:users,email,' . $userDetail['id'],
                               'profile' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        if($request->hasFile('profile'))
        {
       
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

           
                $dir        = 'uploads/avatar';
             
            $image_path = $dir . $userDetail['avatar'];
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $url = '';
            $path = Utility::upload_file($request,'profile',$fileNameToStore,$dir,[]);
            
            if($path['flag'] == 1){
                $url = $path['url'];
            }else{
                return redirect()->route('profile', \Auth::user()->id)->with('error', __($path['msg']));
            }

        }

        if(!empty($request->profile))
        {
            $user['avatar'] = $fileNameToStore;
        }
        $user['name']  = $request['name'];
        $user['email'] = $request['email'];
        $user->save();

        if(\Auth::user()->type == 'employee')
        {
            $employee        = Employee::where('user_id', $user->id)->first();
            $employee->email = $request['email'];
            $employee->save();
        }

        return redirect()->back()->with(
            'success', 'Profile successfully updated.'
        );
    }

    public function updatePassword(Request $request)
    {
        if(\Auth::Check())
        {
            $request->validate(
                [
                    'current_password' => 'required',
                    'new_password' => 'required|min:6',
                    'confirm_password' => 'required|same:new_password',
                ]
            );
            $objUser          = Auth::user();
            $request_data     = $request->All();
            $current_password = $objUser->password;
            if(Hash::check($request_data['current_password'], $current_password))
            {
                $user_id            = Auth::User()->id;
                $obj_user           = User::find($user_id);
                $obj_user->password = Hash::make($request_data['new_password']);;
                $obj_user->save();

                return redirect()->route('profile', $objUser->id)->with('success', __('Password successfully updated.'));
            }
            else
            {
                return redirect()->route('profile', $objUser->id)->with('error', __('Please enter correct current password.'));
            }
        }
        else
        {
            return redirect()->route('profile', \Auth::user()->id)->with('error', __('Something is wrong.'));
        }
    }

    public function notificationSeen($user_id)
    {
        Notification::where('user_id', '=', $user_id)->update(['is_read' => 1]);

        return response()->json(['is_success' => true], 200);
    }
}
