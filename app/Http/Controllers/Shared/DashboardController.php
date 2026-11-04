<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // return 'here'; 
        return view('admin.dashboard');
    }


    public function customer()
    {
    //    return view('user.dashboard');
    }
}