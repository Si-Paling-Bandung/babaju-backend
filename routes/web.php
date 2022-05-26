<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ============================================================================
// =============================== P U B L I C ================================
// ============================================================================

Route::get('/', function () {
    return "Welcome to API";
});

// =============================== H A P U S ================================

// ============================================================================
// ================================ L O G I N =================================
// ============================================================================

Auth::routes([
    'register' => false, // Register Routes...
    'reset' => false, // Reset Password Routes...
    'verify' => false, // Email Verification Routes...
]);


Route::middleware('auth')->group(function () {

    // Home
    Route::get('/home', 'HomeController@index')->name('home');

    // Profile
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    // About
    Route::get('/about', function () {
        return view('about');
    })->name('about');

    // ============================================================================
    // ================================ A D M I N =================================
    // ============================================================================

    Route::middleware('admin')->group(function () {

        // ============================================================================
        // ================================ U S E R  ==================================
        // ============================================================================

        Route::prefix('user')->name('user')->group(function () {
            Route::get('/', 'UsersController@index')->name('');
            Route::get('/create', 'UsersController@create_view')->name('.create');
            Route::post('/create', 'UsersController@create_process')->name('.create.process');
            Route::get('/{id}/update', 'UsersController@update_view')->name('.update');
            Route::post('/{id}/update}', 'UsersController@update_process')->name('.update.process');
            Route::post('/{id}/update-password}', 'UsersController@change_password')->name('.update.password.process');
            Route::get('/{id}/delete}', 'UsersController@delete')->name('.delete');
        });

        Route::prefix('product')->name('product')->group(function () {
            Route::get('/', 'ProductController@index')->name('');
            Route::get('/create', 'ProductController@create_view')->name('.create');
            Route::post('/create', 'ProductController@create_process')->name('.create.process');
            Route::get('/{id}/delete}', 'ProductController@delete')->name('.delete');

            Route::get('/{id}/variant', 'ProductVariantController@index')->name('.variant');
            Route::get('/{id}/variant/create', 'ProductVariantController@create_view')->name('.variant.create');
            Route::post('/{id}/variant/create', 'ProductVariantController@create_process')->name('.variant.create.process');
            Route::get('/{id}/variant/{id_product_variant}/delete}', 'ProductVariantController@delete')->name('.variant.delete');
        });

        Route::prefix('forum')->name('forum')->group(function () {
            Route::get('/', 'ThreadController@index')->name('');
            Route::get('/create', 'ThreadController@create_view')->name('.create');
            Route::post('/create', 'ThreadController@create_process')->name('.create.process');
            Route::get('/{id}/delete}', 'ThreadController@delete')->name('.delete');
        });

        Route::prefix('education')->name('education')->group(function () {
            Route::get('/', 'EducationController@index')->name('');
            Route::get('/create', 'EducationController@create_view')->name('.create');
            Route::post('/create', 'EducationController@create_process')->name('.create.process');
            Route::get('/{id}/delete}', 'EducationController@delete')->name('.delete');
        });

        Route::prefix('crowdfunding')->name('crowdfunding')->group(function () {
            Route::get('/', 'ProjectController@index')->name('');
            Route::get('/create', 'ProjectController@create_view')->name('.create');
            Route::post('/create', 'ProjectController@create_process')->name('.create.process');
            Route::get('/{id}/delete}', 'ProjectController@delete')->name('.delete');
        });
    });
});
