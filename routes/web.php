<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\CharityController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/donate', [DonateController::class, 'index'])->middleware(['auth', 'verified'])->name('donate');
// Display all donations


// Show the form to create a new donation
Route::get('/donations/create', [DonateController::class, 'create'])->name('donations.create');

// Store a new donation
Route::post('/donations', [DonateController::class, 'store'])->name('donations.store');

// Show the form for editing a donation
Route::get('/donations/{donation}/edit', [DonateController::class, 'edit'])->name('donations.edit');

// Update a specific donation
Route::put('/donations/{donation}', [DonateController::class, 'update'])->name('donations.update');

// Delete a specific donation
Route::delete('/donations/{donation}', [DonateController::class, 'destroy'])->name('donations.destroy');



Route::get('/charities', [CharityController::class, 'index'])->name('charities.index');
Route::post('/charities', [CharityController::class, 'store'])->name('charities.store');
Route::get('/charities', [CharityController::class, 'index'])->name('charities.index');
Route::post('/charities', [CharityController::class, 'store'])->name('charities.store');
// Add routes for edit, update, and delete
Route::get('/charities/{charity}/edit', [CharityController::class, 'edit'])->name('charities.edit');
Route::put('/charities/{charity}', [CharityController::class, 'update'])->name('charities.update');
Route::delete('/charities/{charity}', [CharityController::class, 'destroy'])->name('charities.destroy');


// Display all categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Store a new category
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

// Show the form for editing a category
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

// Update a category
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

// Delete a category
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');







Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
