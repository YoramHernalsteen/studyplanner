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
    //COURSES
    Route::post('/courses/create/{period}', [CourseController::class, 'store']);
    //CHAPTERS
    Route::post('/chapters/create/{course}', [ChapterController::class, 'store']);
    Route::post('/chapters/change-status/{chapter}',[ChapterController::class, 'updateStatus']);
});
