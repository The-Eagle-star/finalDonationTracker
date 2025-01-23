<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

use App\Models\Charity;
use App\Models\Category;

class DonateController extends Controller
{
    public function index()
    {
        $donations = Donation::with(['charity', 'category'])->get();
        $charities = Charity::all();
        $categories = Category::all();
       
        
        return view('donate', compact('donations', 'charities', 'categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'charity_id' => 'required|exists:charities,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Donation::create([
            'charity_id' => $request->charity_id,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('donate')->with('success', 'Donation added successfully.');
    }
    public function edit($id)
{
    $donation = Donation::findOrFail($id);
    $charities = Charity::all();
    $categories = Category::all();

    return view('donations.edit', compact('donation', 'charities', 'categories'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'charity_id' => 'required|exists:charities,id',
        'category_id' => 'required|exists:categories,id',
        'amount' => 'required|numeric',
        'date' => 'required|date',
        'notes' => 'nullable|string',
    ]);

    $donation = Donation::findOrFail($id);
    $donation->update([
        'charity_id' => $request->charity_id,
        'category_id' => $request->category_id,
        'amount' => $request->amount,
        'date' => $request->date,
        'notes' => $request->notes,
    ]);

    return redirect()->route('donate')->with('success', 'Donation updated successfully.');
}
public function destroy($id)
{
    $donation = Donation::findOrFail($id);
    $donation->delete();

    return redirect()->route('donate')->with('success', 'Donation deleted successfully.');
}

}
