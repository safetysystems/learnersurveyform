<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AboutYourTrainingQuestionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('feedback.index');
    });

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/export/all', [FeedbackController::class, 'exportAllResponses'])->name('feedback.export.all');
    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    Route::get('/feedback/{feedback}/responses', [FeedbackController::class, 'responses'])->name('feedback.responses');
    Route::get('/feedback/{feedback}/responses/create', [FeedbackController::class, 'createResponse'])->name('feedback.responses.create');
    Route::post('/feedback/{feedback}/responses', [FeedbackController::class, 'storeResponse'])->name('feedback.responses.store');
    Route::get('/feedback/{feedback}/responses/{form}', [FeedbackController::class, 'showResponse'])->name('feedback.responses.show');
    Route::get('/feedback/{feedback}/export', [FeedbackController::class, 'exportResponses'])->name('feedback.export');
    Route::get('/feedback/{feedback}/import-image', [FeedbackController::class, 'showImageImport'])->name('feedback.import.image');
    Route::post('/feedback/{feedback}/import-image', [FeedbackController::class, 'processImageImport'])->name('feedback.import.image.process');
    Route::get('/feedback/{feedback}/import-preview', [FeedbackController::class, 'showImagePreview'])->name('feedback.import.preview');
    Route::post('/feedback/{feedback}/import-confirm', [FeedbackController::class, 'confirmImageImport'])->name('feedback.import.confirm');

    Route::get('/questions', [AboutYourTrainingQuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [AboutYourTrainingQuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [AboutYourTrainingQuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}/edit', [AboutYourTrainingQuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [AboutYourTrainingQuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [AboutYourTrainingQuestionController::class, 'destroy'])->name('questions.destroy');

    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

    Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::post('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/password', [UserManagementController::class, 'editPassword'])->name('users.password.edit');
    Route::post('/users/{user}/password', [UserManagementController::class, 'updatePassword'])->name('users.password.update');
});

Route::get('/survey/{feedback}', [FeedbackController::class, 'showSurvey'])->name('survey.show');
Route::post('/survey/{feedback}', [FeedbackController::class, 'submitSurvey'])->name('survey.submit');
Route::get('/survey-response/{form}/download', [FeedbackController::class, 'downloadResponse'])->name('survey.response.download');

Route::get('/employer-survey/{feedback}', [FeedbackController::class, 'showEmployerSurvey'])->name('employer.survey.show');
Route::post('/employer-survey/{feedback}', [FeedbackController::class, 'submitEmployerSurvey'])->name('employer.survey.submit');
