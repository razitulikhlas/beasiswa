<?php

namespace App\Http\Controllers;

class LoginController extends Controller{

    function index()
    {
        return view('layouts.login', ["title" => "Login"]);
    }

}

