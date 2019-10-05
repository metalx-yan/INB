<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function test()
    {
        $permissions = Permission::whereNull('permission_id')->get();

        return view('button', compact('permissions'));
    }
}
