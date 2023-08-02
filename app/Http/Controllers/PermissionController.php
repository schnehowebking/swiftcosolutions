<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{

    public function index()
    {
//        return redirect()->back();

        $permissions = Permission::all();

        return view('permission.index')->with('permissions', $permissions);

    }

    public function create()
    {
//        return redirect()->back();
        $roles = Role::get();

        return view('permission.create')->with('roles', $roles);

    }

    public function store(Request $request)
    {
//        return redirect()->back();

        $this->validate(
            $request, [
                        'name' => 'required|max:40',
                    ]
        );

        $name             = $request['name'];
        $permission       = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        if(!empty($request['roles']))
        {
            foreach($roles as $role)
            {
                $r          = Role::where('id', '=', $role)->firstOrFail();
                $permission = Permission::where('name', '=', $name)->first();
                $r->givePermissionTo($permission);
            }
        }

        return redirect()->route('permissions.index')->with(
            'success', 'Permission ' . $permission->name . ' added!'
        );

    }


    public function edit(Permission $permission)
    {
//        return redirect()->back();

        $roles = Role::where('created_by', '=', \Auth::user()->creatorId())->get();

        return view('permission.edit', compact('roles', 'permission'));

    }

    public function update(Request $request, Permission $permission)
    {
//        return redirect()->back();
        $permission = Permission::findOrFail($permission['id']);
        $this->validate(
            $request, [
                        'name' => 'required|max:40',
                    ]
        );
        $input = $request->all();
        $permission->fill($input)->save();

        return redirect()->route('permissions.index')->with(
            'success', 'Permission ' . $permission->name . ' updated!'
        );
    }

    public function destroy($id)
    {

//        return redirect()->back();
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index')->with(
            'success', 'Permission deleted!'
        );


    }
}
