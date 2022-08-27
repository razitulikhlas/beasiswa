<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{

    function index()
    {
        return view('layouts.login', ["title" => "Login"]);
    }
/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'email'=>'required|email:dns',
            'password'=>'required'
        ]);

        // return dd('success');

        if(Auth::attempt($validate)){
            $request->session()->regenerate();
            return redirect()->intended('/siswa');
        }
        return back()->with("loginError","Login Failed");
    }


}

