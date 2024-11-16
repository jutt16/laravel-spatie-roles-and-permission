<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    //this method will show permission page
    public function index() {
        return view('permissions.list');
    }

    //this method will show create permission page
    public function create() {
        return view('permissions.create');
    }

    //this method will insert a permission in db
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions|min:3',
        ]);

        if($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success','Permission Added Successfully');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    //this method will show edit permission page
    public function edit() {

    }

    //this method will update a permission in db
    public function update() {

    }

    //this method will delete a permission in db
    public function destroy() {

    }
}
