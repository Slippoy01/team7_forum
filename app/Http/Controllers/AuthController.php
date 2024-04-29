<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        //
        return view('auth.login');
    }

    public function forgotPassword()
    {
        //
        return view('auth.forgot-password');
    }

    public function register()
    {
        //
        return view('auth.register');
    }
}
