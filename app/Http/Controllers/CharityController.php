<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charity;

class CharityController extends Controller
{
    public function index()
    {
        $charities = Charity::all(); // Get all charities
        return view('charity', compact('charities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'short_description' => 'required|string|max:500',
            'total_donations' => 'required|numeric|min:0',
        ]);

        // Handle file upload
        $logoPath = $request->file('logo')->store('charity_logos', 'public');

        Charity::create([
            'title' => $request->title,
            'logo' => $logoPath,
            'short_description' => $request->short_description,
            'total_donations' => $request->total_donations,
        ]);

        return redirect()->route('charities.index')->with('success', 'Charity added successfully.');
    }
    public function update(Request $request, $id)
{
    $charity = Charity::findOrFail($id);
    
    $request->validate([
        'title' => 'required|string|max:255',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif',
        'short_description' => 'required|string',
        'total_donations' => 'required|numeric',
    ]);

    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('charity_logos', 'public');
        $charity->logo = $logoPath;
    }

    $charity->title = $request->input('title');
    $charity->short_description = $request->input('short_description');
    $charity->total_donations = $request->input('total_donations');
    $charity->save();

    return redirect()->route('charities.index')->with('success', 'Charity updated successfully');
}
public function destroy($id)
{
    // Find the charity by ID
    $charity = Charity::findOrFail($id);

    // Delete the charity record
    $charity->delete();

    // Redirect back with a success message
    return redirect()->route('charities.index')->with('success', 'Charity deleted successfully');
}


}
