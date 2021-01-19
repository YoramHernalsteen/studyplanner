<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function documentation(){
        return view('courses.index', [
            'user'=> Auth::user(),
        ]);
    }
}
