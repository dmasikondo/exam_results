<?php

use App\Http\Controllers\ExamResultController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/myresults',[ExamResultController::class, 'getLatestIntakeResultsForPaidUpUser'])->middleware(['auth'])->name('myresults');
Route::view('checkMyresults', 'examresults.checked-results')
    ->middleware(['auth'])
    ->name('check-results');
Route::post('checkMyresults',[ExamResultController::class,'checkMyresults'])->middleware(['auth']);

require __DIR__.'/auth.php';
