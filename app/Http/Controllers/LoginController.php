<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use illuminate\Http\Request;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
    }
}