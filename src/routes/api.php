<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Blog\BlogApiController;
use App\Http\Controllers\Api\User\UserApiController;
use App\Http\Controllers\Api\Profile\ProfileApiController;
use App\Http\Controllers\Api\Questions\AnswerApiController;
use App\Http\Controllers\Api\Questions\QuestionApiController;
use App\Http\Controllers\Api\Questions\QuestionerApiController;
use App\Http\Controllers\Api\Questions\QuestionGroupApiController;

/**
 * Authentication routes
 */
Route::prefix("/user/")
    ->as('users.')
    ->group(function () {
        Route::post('register/request', [UserApiController::class, 'registerRequest'])->name('register.request');
        Route::post('login/request', [UserApiController::class, 'loginRequest'])->name('login.request');
        Route::post('login/token', [UserApiController::class, 'loginToken'])->name('login.token');
        Route::get('is-admin', [UserApiController::class, 'isAdmin'])->name('isAdmin')->middleware('auth:sanctum');

        Route::get('logout', [UserApiController::class, 'logout'])
            ->name('logout')
            ->middleware('auth:sanctum');
    });

/**
 * Admin users routes
 */
Route::prefix("/users/")
    ->as('users.')
    ->middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {
        Route::get('', [UserApiController::class, 'index'])->name('index');
        Route::delete('{user:id}/super-admin', [UserApiController::class, 'removeSuperAdmin'])->name(
            'super-admin.remove'
        );
        Route::post('{user:id}/super-admin', [UserApiController::class, 'addSuperAdmin'])->name('super-admin.add');
    });

/**
 * Profile routes
 */
Route::prefix("/profile/")
    ->as('profile.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('general', [ProfileApiController::class, 'general'])->name('general');
    });

/**
 * Questioner routes
 */
Route::prefix("/questioners/")
    ->as('questioners.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('', [QuestionerApiController::class, 'store'])->name('create');
        Route::post('{questioner:id}', [QuestionerApiController::class, 'update'])->name('update');
        Route::get('', [QuestionerApiController::class, 'index'])->name('index')->withoutMiddleware('auth:sanctum');
        Route::get('{questioner:id}', [QuestionerApiController::class, 'item'])->name('item')->withoutMiddleware(
            'auth:sanctum'
        );
        Route::delete('{questioner:id}/delete', [QuestionerApiController::class, 'delete'])->name('delete');
    });

/**
 * Question Group routes
 */
Route::prefix("/question-groups/")
    ->as('question_group.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('', [QuestionGroupApiController::class, 'store'])->name('create');
        Route::post('{question_group:id}', [QuestionGroupApiController::class, 'update'])->name('update');
        Route::get('', [QuestionGroupApiController::class, 'index'])->name('index')->withoutMiddleware('auth:sanctum');
        Route::get('{question_group:id}', [QuestionGroupApiController::class, 'item'])->name('item')->withoutMiddleware(
            'auth:sanctum'
        );
        Route::delete('{question_group:id}/delete', [QuestionGroupApiController::class, 'delete'])->name('delete');
    });

/**
 * Question routes
 */
Route::prefix("/question-groups/{question_group:id}/questions/")
    ->as('question.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('', [QuestionApiController::class, 'store'])->name('create');
        Route::post('{question:id}', [QuestionApiController::class, 'update'])->name('update');
        Route::get('', [QuestionApiController::class, 'index'])->name('index')->withoutMiddleware('auth:sanctum');
        Route::get('{question:id}', [QuestionApiController::class, 'item'])->name('item')->withoutMiddleware(
            'auth:sanctum'
        );
        Route::delete('{question:id}', [QuestionApiController::class, 'delete'])->name('delete');
    });

/**
 * Blog routes
 */
Route::prefix("/blogs/")
    ->as('blog.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('', [BlogApiController::class, 'store'])->name('create');
        Route::post('{blog:id}', [BlogApiController::class, 'update'])->name('update');
        Route::get('', [BlogApiController::class, 'index'])->name('index')->withoutMiddleware('auth:sanctum');
        Route::get('{blog:slug}', [BlogApiController::class, 'item'])->name('item')->withoutMiddleware('auth:sanctum');
        Route::delete('{blog:id}', [BlogApiController::class, 'delete'])->name('delete');
    });

/**
 * Answer routes
 */
Route::prefix("/question-groups/{question_group:id}/")
    ->as('question.answer.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('questions/{question}/answer', [AnswerApiController::class, 'store'])->name('create');
        Route::get('finish', [AnswerApiController::class, 'finish'])->name('finish');
    });
