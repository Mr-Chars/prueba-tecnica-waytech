<?php

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

Route::prefix('/')->group(base_path('routes/api.php'));
// Route::get('/', function () {
//     return view('welcome', ["posts" => 'xddddd']);
// });

// Route::controller(UserController::class)->group(function () {
//     Route::get('/user-search', 'search');
// });
