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

require __DIR__.'/auth.php';
