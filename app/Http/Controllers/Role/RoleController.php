<?php

namespace App\Http\Controllers\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;

class RoleController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Role::latest()->get();
    }
}
