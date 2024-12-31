<?php
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AdminController;
Route::resource('exams', ExamController::class);
Route::resource('questions', QuestionController::class);

Route::get('exam/{exam}/start', [ExamController::class, 'start'])->name('exam.start');
Route::post('exam/{exam}/submit', [ExamController::class, 'submit'])->name('exam.submit');


// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
//     Route::resource('admin/exams', ExamController::class);
//     Route::resource('admin/questions', QuestionController::class);
// });
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

// Display the registration form
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Handle the registration form submission
Route::post('register', [RegisterController::class, 'register']);

// Display the login form
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Handle the login form submission
Route::post('login', [LoginController::class, 'login']);

// Handle logout
Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
Route::middleware('auth')->get('/home', function () {
    return view('home');
})->name('home');
