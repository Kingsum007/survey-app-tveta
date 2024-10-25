<?php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ResponseController;
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::resource('surveys', SurveyController::class);
    Route::post('surveys/{survey}/responses', [ResponseController::class, 'store'])->name('responses.store');
});

// About and Home Routes
Route::view('/', 'home')->name('home');
Route::view('/home', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::get('surveys/{survey}/responses', [SurveyController::class, 'showResponses'])->name('surveys.responses');
Route::get('/surveys/{survey}/statistics', [SurveyController::class, 'showStatistics'])
    ->name('surveys.statistics');

Route::get('/survey/{token}',[SurveyController::class,'showPublicSurvey'])->name('surveys.public');;
