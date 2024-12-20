<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ResponseController;
use App\Http\Middleware\AdminMiddleware;
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::resource('surveys', SurveyController::class);
    Route::post('surveys/{survey}/responses', [ResponseController::class, 'store'])->name('responses.store');
});
Route::get('/survey-list',[SurveyController::class, 'index'])->name('survey-list');

// About and Home Routes
Route::view('/', 'home')->name('home');
Route::view('/home', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::get('surveys/{survey}/responses', [SurveyController::class, 'showResponses'])->name('surveys.responses');
Route::get('/surveys/{survey}/statistics', [SurveyController::class, 'showStatistics'])
    ->name('surveys.statistics');

Route::get('/survey/{token}',[SurveyController::class,'showPublicSurvey'])->name('surveys.public');
Route::middleware(['auth'])->group(function(){
    Route::resource('control',AdminController::class);
    Route::get('/control/surveys',[AdminController::class,'surveys'])->name('admin.surveys.index');
});
Route::get('/check',[AdminController::class, 'index']);
