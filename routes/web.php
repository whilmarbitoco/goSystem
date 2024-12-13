<?php

use App\Http\Controllers\GcashController;
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
Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'verified']);


Route::get('/dashboard', function () {

	$tenantprofile = \App\Models\Tenantprofile::all();
    $booking = \App\Models\Booking::all();
    $room = \App\Models\Room::all();
    $bed = \App\Models\Bed::all();
    
    return view('dashboard', [
	    'tenantprofiles' => $tenantprofile,
'bookings' => $booking,
        'rooms' => $room,
        'beds' => $bed,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('pay',[GcashController::class,'pay']);
Route::get('success',[GcashController::class,'success']);

