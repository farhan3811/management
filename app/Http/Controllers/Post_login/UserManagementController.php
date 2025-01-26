<?php

namespace App\Http\Controllers\Post_login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManagementController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
        return view('post-login-views.user_management.home');
    }
}
