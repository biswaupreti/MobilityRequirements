<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    public $user = '';

    public function __construct()
    {
        $this->middleware('auth');
        if(Auth::user()){
            $this->user = Auth::user();
        }

        View::share('authUser', $this->user);
    }
}
