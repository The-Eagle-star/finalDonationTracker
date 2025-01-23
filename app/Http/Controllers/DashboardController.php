<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

use App\Models\Charity;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDonations = Donation::sum('amount');
        $donationsThisMonth = Donation::whereMonth('date', now()->month)->sum('amount');
        $categories = Category::withSum('donations', 'amount')->get();
    $totalDonationsPerCategory = $categories->map(function ($category) {
        return [
            'name' => $category->name,
            'total_donations' => number_format($category->donations_sum_amount, 2) . ' KES',
            'icon' => 'fas fa-euro-sign', // Set your desired icon here
        ];
    });
    $latestDonation = Donation::latest()->first();
    $charity = $latestDonation->charity;
    $totalDonationsMade = $charity->donations()->sum('amount');

            // Calculate remaining balance for the charity
            $remainingBalance = max(0, $charity->total_donations - $totalDonationsMade);
              // Query total donations per month for the last 6 months
        $donations = Donation::selectRaw('SUM(amount) as total, MONTH(date) as month')
        ->where('date', '>=', now()->subMonths(6))  // Last 6 months
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();
        // Prepare the data for the chart
        $labels = [];
        $data = [];

        foreach ($donations as $donation) {
            // Add month names to the labels
            $labels[] = \Carbon\Carbon::create()->month($donation->month)->format('F');
            // Add the total donation amounts to the data array
            $data[] = (float) $donation->total;
        }

        $categoryDonations = \App\Models\Category::selectRaw('categories.name as category_name, SUM(donations.amount) as total_donations')
            ->join('donations', 'donations.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->get();

        // Prepare the data for the chart
        $pielabels = [];
        $piedata = [];
        $piecolors = [
            'rgba(255, 99, 132, 0.2)', // Red
            'rgba(54, 162, 235, 0.2)', // Blue
            'rgba(255, 206, 86, 0.2)', // Yellow
            'rgba(75, 192, 192, 0.2)', // Green
            'rgba(153, 102, 255, 0.2)', // Purple
            'rgba(255, 159, 64, 0.2)', // Orange
        ];

        // Loop through the results and prepare labels, data, and colors for the chart
        foreach ($categoryDonations as $index => $categoryDonation) {
            $pielabels[] = $categoryDonation->category_name;
            $piedata[] = (float) $categoryDonation->total_donations;
        }
        
        return view('dashboard', compact('totalDonations','donationsThisMonth','totalDonationsPerCategory','latestDonation','charity','totalDonationsMade','remainingBalance','labels',
    'data','pielabels','piedata','piecolors'));
    }
    
}
