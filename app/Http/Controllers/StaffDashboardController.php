<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
       public function staffDashboard()
    {
        return view('staff.dashboard');
    }
}
