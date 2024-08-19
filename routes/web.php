<?php

use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');


Route::middleware(['auth','verified','reset'])->group(function(){
Route::get('/users/activate-account',[UserController::class, 'activate'])
    ->name('account-activate')
    ->withoutMiddleware('reset');

Route::put('/users/activate-account',[UserController::class, 'activation'])
    ->withoutMiddleware('reset');

    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::get('/myresults',[ExamResultController::class, 'getLatestIntakeResultsForPaidUpUser'])
        ->name('myresults');

    Route::view('checkMyresults', 'examresults.checked-results')
        ->name('check-results');

    Route::post('checkMyresults',[ExamResultController::class,'checkMyresults']);

    Route::view('send-proof-of-payment', 'fees.send-proof-ofpayment')
        ->name('proof-of-payment');

    });
    Route::get('/users/registration', [UserController::class, 'create'])
        ->name('staff-user-create');

    Route::post('/users/registration', [UserController::class, 'store'])
        ->name('user-store');

    Route::get('/users/{user:slug}/edit', [UserController::class, 'edit'])
        ->name('user-edit');

    Route::put('/users/{user:slug}', [UserController::class, 'update'])
        ->name('user-update');

    Route::get('/users', [UserController::class, 'index'])
        ->name('users');

require __DIR__.'/auth.php';
