<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // Retrieve all categories from the database
        $categories = Category::all();

        // Pass the categories to the view
        return view('category', compact('categories'));
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new category
        Category::create([
            'name' => $request->name,
        ]);

        // Redirect back to the categories page with a success message
        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    // Show the form for editing a specific category
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Update the specified category in storage
    public function update(Request $request, Category $category)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the category
        $category->update([
            'name' => $request->name,
        ]);

        // Redirect back to the categories page with a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // Remove the specified category from storage
    public function destroy(Category $category)
    {
        // Delete the category
        $category->delete();

        // Redirect back to the categories page with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
