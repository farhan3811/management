<?php

namespace App\Http\Controllers\Post_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
        // echo auth()->user()->hasRole('main_docter');
        return view('post-login-views.home');
    }
}
