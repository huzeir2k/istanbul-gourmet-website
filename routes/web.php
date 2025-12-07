<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Serve the main Vue SPA for all public pages
// The Vue router in App.vue will handle which page to display
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/shop', function () {
    return view('welcome');
})->name('shop');

Route::get('/about', function () {
    return view('welcome');
})->name('about');

Route::get('/contact', function () {
    return view('welcome');
})->name('contact');

Route::get('/products/{id}', function () {
    return view('welcome');
})->name('products.show');

// Dashboard (authenticated users only)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
