<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controller

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\ApiController;

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

// =======================================================================================
// ================================= Public Routes =======================================
// =======================================================================================

// ==================================== Authentication ===================================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ======================================== Others =======================================
Route::get('/landing', [ApiController::class, 'landing']);
Route::get('/waAdmin', [ApiController::class, 'waAdmin']);

// ================================== Wrong Token ByPass =================================
Route::get('/wrongToken', function () {
    return response()->json([
        'status' => 'failed',
        'message' => 'Your token is expired',
    ], 400);
});

// =======================================================================================
// ================================= With Token Routes ===================================
// =======================================================================================

Route::group(['middleware' => ['auth:sanctum']], function () {


    // ================================== Authentication =================================
    Route::get('/logout', [AuthController::class, 'logout']);

    // ====================================== History ======================================
    Route::post('/profile/update/tb-bb-color', [ApiController::class, 'update_tb_bb_color']);

    // ====================================== Product ======================================
    Route::get('/product/{id}', [ApiController::class, 'detail_produk']);

    // ====================================== Funding ======================================
    Route::get('/funding/{id}', [ApiController::class, 'detail_funding']);

    // ====================================== Komunitas ======================================
    Route::get('/forum', [ApiController::class, 'forum']);
    Route::get('/berita/{id}', [ApiController::class, 'detail_berita']);

    // ====================================== Education ======================================
    Route::get('/tips/{id}', [ApiController::class, 'detail_tips']);











    // ==================================== Profile ======================================
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile/update', [AuthController::class, 'update_profile']);
});

// =======================================================================================
// =======================================================================================
// =======================================================================================
