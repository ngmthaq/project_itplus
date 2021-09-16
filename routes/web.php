<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\UserController;
use App\Models\Category;
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

// Homepage
Route::get('/', function() {
    return view('web.main.homepage', [
        'categories' => Category::all(),
        'site' => 'homepage'
    ]);
});

// Register
Route::get('/register', [RegisterController::class, 'show'])
    ->name('register.show')
    ->middleware(['authUserCantAccessToLoginAndRegister']);
Route::post('/register', [RegisterController::class, 'register'])
    ->name('register')
    ->middleware(['authUserCantAccessToLoginAndRegister']);

// Verify email
Route::get('/verify/{user:remember_token}', [RegisterController::class, 'verify'])
    ->name('verify')
    ->where(['user' => '[a-zA-Z0-9]+'])
    ->middleware(['authUserCantAccessToLoginAndRegister']);

// Login
Route::get('/login', [LoginController::class, 'show'])
    ->name('login.show')
    ->middleware(['authUserCantAccessToLoginAndRegister']);
Route::post('/login', [LoginController::class, 'login'])
    ->name('login')
    ->middleware(['authUserCantAccessToLoginAndRegister']);

// Logout
Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Change password
Route::get('users/password/change', [UserController::class, 'changePasswordForm'])
    ->name('user.changePasswordForm')
    // ->where(['user' => '[1-9]{1}\d{0,}'])
    ->middleware(['authCheck']);
Route::post('users/password/change', [UserController::class, 'changePassword'])
    ->name('user.changePassword')
    // ->where(['user' => '[1-9]{1}\d{0,}'])
    ->middleware('authCheck');