<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/login', [LoginController::class, 'login'])->name('userLogin');
Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api,admin-api', 'scopes:user']], function () {
    // authenticated staff routes here
    Route::get('dashboard', [LoginController::class, function (Request $request) {
        return  $request->user();
    }]);
});


Route::post('admin/login', [LoginController::class, 'adminLogin']);
Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin']], function () {
    // authenticated staff routes here

    Route::get('dashboard', [LoginController::class, function (Request $request) {

        // if ($request->user()->tokenCan('admin')) {

        return  $request->user();
        // }
    }]);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:admin-api');
