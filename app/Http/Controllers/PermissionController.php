<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //this method will show permission page
    public function index() {

    }

    //this method will show create permission page
    public function create() {
        return view('permissions.create');
    }

    //this method will insert a permission in db
    public function store() {

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
