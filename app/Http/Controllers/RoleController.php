<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Role'))
        {
            $roles = Role::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('role.index')->with('roles', $roles);
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function create()
    {
        if(\Auth::user()->can('Create Role'))
        {
            $user = \Auth::user();
            if($user->type == 'super admin' || $user->type == 'company')
            {
                $permissions = Permission::all()->pluck('name', 'id')->toArray();
            }
            else
            {
                $permissions = new Collection();
                foreach($user->roles as $role)
                {
                    $permissions = $permissions->merge($role->permissions);
                }
                $permissions = $permissions->pluck('name', 'id')->toArray();

            }

            return view('role.create', ['permissions' => $permissions]);
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Role'))
        {
            $role = Role::where('name', '=', $request->name)->first();
            if(isset($role))
            {
                return redirect()->back()->with('error', __('The Role has Already Been Taken.'));
            }
            else
            {
                $this->validate(
                    $request, [
                                'name' => 'required|max:100|unique:roles,name,NULL,id,created_by,' . \Auth::user()->creatorId(),
                                'permissions' => 'required',
                            ]
                );

                $name             = $request['name'];
                $role             = new Role();
                $role->name       = $name;
                $role->created_by = \Auth::user()->creatorId();
                $permissions      = $request['permissions'];
                $role->save();

                foreach($permissions as $permission)
                {
                    $p    = Permission::where('id', '=', $permission)->firstOrFail();
                    $role = Role::where('name', '=', $name)->first();
                    $role->givePermissionTo($p);
                }

                return redirect()->route('roles.index')->with('success', 'Role successfully created.');

            }


        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }


    }

    public function edit(Role $role)
    {

        if(\Auth::user()->can('Edit Role'))
        {

            $user = \Auth::user();
            if($user->type == 'super admin' || $user->type == 'company')
            {
                $permissions = Permission::all()->pluck('name', 'id')->toArray();

            }
            else
            {
                $permissions = new Collection();
                foreach($user->roles as $role1)
                {
                    $permissions = $permissions->merge($role1->permissions);
                }
                $permissions = $permissions->pluck('name', 'id')->toArray();
            }


            return view('role.edit', compact('role', 'permissions'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }


    }

    public function update(Request $request, Role $role)
    {
        if(\Auth::user()->can('Edit Role'))
        {
            if($role->name == 'employee')
            {
                $this->validate(
                    $request, [
                                'permissions' => 'required',
                            ]
                );
            }
            else
            {
                $this->validate(
                    $request, [
                                'name' => 'required|max:100|unique:roles,name,' . $role['id'] . ',id,created_by,' . \Auth::user()->creatorId(),
                                'permissions' => 'required',
                            ]
                );
            }

            $input       = $request->except(['permissions']);
            $permissions = $request['permissions'];
            $role->fill($input)->save();

            $p_all = Permission::all();

            foreach($p_all as $p)
            {
                $role->revokePermissionTo($p);
            }

            foreach($permissions as $permission)
            {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()->route('roles.index')->with('success', 'Role successfully updated.');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function destroy(Role $role)
    {
        if(\Auth::user()->can('Delete Role'))
        {
            $role->delete();

            return redirect()->route('roles.index')->with(
                'success', 'Role successfully deleted.'
            );
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }


    }
}
