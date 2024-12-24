<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // this method will show roles page
    public function index() {

    }

    // this method will show create roles page
    public function create() {
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('roles.create', [
            'permissions'=> $permissions
        ]);
    }

    // this method will insert a role in db
    public function store() {

    }
}
