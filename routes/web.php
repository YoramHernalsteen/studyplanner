<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ChapterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'auth'], function(){
    //PERIODS
    Route::get('/', [PeriodController::class, 'index']);
    Route::get('/periods/{period}', [PeriodController::class, 'show']);
    Route::post('/periods/create', [PeriodController::class,'store']);
    Route::post('/periods/edit/{period}', [PeriodController::class, 'update']);
    Route::post('/periods/delete/{period}', [PeriodController::class, 'destroy']);
    //COURSES
    Route::get('/courses/show/{course}', [CourseController::class, 'show']);
    Route::post('/courses/create/{period}', [CourseController::class, 'store']);
    Route::post('/courses/edit/{course}', [CourseController::class, 'update']);
    Route::post('/courses/delete/{course}', [CourseController::class, 'destroy']);
    //CHAPTERS
    Route::post('/chapters/create/{course}', [ChapterController::class, 'store']);
    Route::post('/chapters/edit/{chapter}', [ChapterController::class, 'update']);
    Route::post('/chapters/delete/{chapter}', [ChapterController::class, 'destroy']);
    Route::post('/chapters/change-status/{chapter}',[ChapterController::class, 'updateStatus']);
});
