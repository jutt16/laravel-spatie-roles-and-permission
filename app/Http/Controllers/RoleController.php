<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // this method will show roles page
    public function index() {
        return view('roles.list');
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
}
