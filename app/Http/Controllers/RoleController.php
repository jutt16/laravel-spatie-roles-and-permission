<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view role', only: ['index']),
            new Middleware('permission:edit role', only: ['edit']),
            new Middleware('permission:create role', only: ['create']),
            new Middleware('permission:delete role', only: ['destroy']),
        ];
    }

    // this method will show roles page
    public function index() {
        $roles = Role::orderBy('name','ASC')->paginate(10);
        return view('roles.list',[
            'roles' => $roles
        ]);
    }

    // this method will show create roles page
    public function create() {
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('roles.create', [
            'permissions' => $permissions
        ]);
    }

    // this method will insert a role in db
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles|min:3',
        ]);

        if($validator->passes()) {
            // dd($request->permission);
            $role = Role::create(['name' => $request->name]);

            if(!empty($request->permission)) {
                foreach($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('roles.index')->with('success','Role Added Successfully');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id) {
        $role = Role::findOrfail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name','ASC')->get();

        return view('roles.edit', [
            'permissions' => $permissions,
            'hasPermissions' => $hasPermissions,
            'role' => $role
        ]);
    }    

    public function update($id, Request $request) {
        $role = Role::findOrfail($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles,name,'.$id.',id',
        ]);

        if($validator->passes()) {
            // dd($request->permission);
            $role->name = $request->name;
            $role->save();

            if(!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success','Role Updated Successfully.');
        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    public function destroy(Request $request) {
        $id = $request->id;
        $role = Role::find($id);

        if($role == null) {
            session()->flash('error', 'Role Not Found.');
            return response()->json([
                'status' => false
            ]);
        }

        $role->delete();
        
        session()->flash('success', 'Role Deleted Successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}
