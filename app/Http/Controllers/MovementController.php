<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function getAccountMtd()
    {
        return view('movements.mtdacc');
    }

    public function getAccountYtd()
    {
        return view('movements.ytdacc');
    }
}
