<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     // $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        // dd(Auth::check());
        // dd(Auth::user());
        // dd(Auth::id());
        return view('home');
    }

    public function contact()
    {
        return view('/contact');
    }

    public function secret()
    {
        return view('/secret');
    }
}
