<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware' => ['cors']], function () {

    Route::controller(UserController::class)->group(function () {
        Route::post('/api-user-getAndPushDataFromExternalDevice', 'getAndPushDataFromExternalDevice');
        Route::get('/api-user-search', 'search');
        Route::post('/api-user-add', 'add');
        Route::put('/api-user-update', 'update');
        Route::delete('/api-user-delete', 'delete');

        Route::get('/user', 'goToUserPage');
    });
});
