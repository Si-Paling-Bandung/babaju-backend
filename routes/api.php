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

    // ==================================== Profile ======================================
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile/update', [AuthController::class, 'update_profile']);

    // ====================================== History ======================================
    Route::get('/history', [ApiController::class, 'history']);

    // ====================================================================================
    // ====================================== Course ======================================
    // ====================================================================================

    // ================================== Topic & Lesson ==================================
    Route::get('/topic', [ApiController::class, 'topic']); //Topic
    Route::get('/topic/{id_topic}', [ApiController::class, 'lo']); //Detail Topic
    Route::get('/lesson/{id_lesson}', [ApiController::class, 'lesson']); // Detail Lesson

    // ===================================== Question ======================================
    Route::get('/question/{id_topic}/{section}', [ApiController::class, 'question']);
    Route::post('/answer-question/{id_topic}/{section}', [ApiController::class, 'answerQuestion']);
    Route::get('/result/{id_topic}/{section}', [ApiController::class, 'answerResult']); // Nggak masuk laporan

    // ======================================= Task ========================================
    // Iterasi 2
    Route::get('/task/{id_topic}', [ApiController::class, 'task']);
    Route::post('/task/{id_topic}', [ApiController::class, 'answerTask']);

    // ===================================== Feedback & Rating  ====================================
    Route::post('/feedback/{id_topic}', [ApiController::class, 'feedback_add']); //Feedback
    Route::post('/rating/{id_topic}', [ApiController::class, 'rating_add']); //Rating

    // ======================================= Certificate ========================================
    // Iterasi 2
    Route::get('/certificate', [ApiController::class, 'certificate_list']);
    Route::get('/certificate/template', [ApiController::class, 'certificate_template']);
    Route::get('/certificate/{id_topic}', [ApiController::class, 'certificate']);
    Route::post('/certificate/{id_topic}', [ApiController::class, 'certificate_upload']);

    // ====================================================================================
    // ==================================== End Course ====================================
    // ====================================================================================

    // =====================================  Favorit ====================================
    Route::get('/favorit', [ApiController::class, 'favorit_index_lesson']);
    Route::post('/favorit/add/{id_lesson}', [ApiController::class, 'favorit_add_lesson']);
    Route::delete('/favorit/delete/{id_lesson}', [ApiController::class, 'favorit_remove_lesson']);

    // ===================================== Announcement  ====================================
    Route::get('/announcement', [ApiController::class, 'announcement']);
});

// =======================================================================================
// =======================================================================================
// =======================================================================================
