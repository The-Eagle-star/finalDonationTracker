<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

use App\Models\Charity;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDonations = Donation::sum('amount');
        $donationsThisMonth = Donation::whereMonth('date', now()->month)->sum('amount');
        
        return view('dashboard', compact('totalDonations','donationsThisMonth'));
    }
    
}
