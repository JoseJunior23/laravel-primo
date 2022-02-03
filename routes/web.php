<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Jobs\ConvertCelsius;
use App\Jobs\FindMaxPrime;
use App\Jobs\MakeDiv;
use App\Jobs\MakeSum;

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

Route::get('soma/{num1}/{num2}', function ($num1, $num2) {
    MakeSum::dispatch($num1, $num2);

    return 'O calculo será realizado em fila';
});

Route::get('/celsius/{farenheit}', function ($celsius) {
    ConvertCelsius::dispatch(($celsius));
    return 'A conversão de temperatura está sendo realizada ...';
});

Route::get('/div/{num1}/{num2}', function ($num1, $num2) {
    MakeDiv::dispatch($num1, $num2, auth()->id());

    return 'A divisão está sendo realizada ...';
});
