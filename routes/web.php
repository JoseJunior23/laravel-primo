<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Jobs\FindMaxPrime;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/primo/{limit}', function ($limit) {
    FindMaxPrime::dispatch($limit, auth()->id());

    return 'O calculo será realizado em fila';
});

Route::get('/notifications', function () {
    $user = auth()->user();
    foreach ($user->unreadNotifications as $noti) {
        echo '<h3>' . $noti->data['description'] . '</h3>';
    }
});
