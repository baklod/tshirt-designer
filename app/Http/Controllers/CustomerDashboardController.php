<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerDashboardController extends Controller 
{
    public function customerDashboard()
    {
        return view('customer.dashboard');
    }
}
