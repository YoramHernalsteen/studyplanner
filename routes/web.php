<?php

use Illuminate\Support\Facades\Route;
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
    //COURSES
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/courses/create', [CourseController::class, 'store']);
    //CHAPTERS
    Route::post('/chapters/change-status/{chapter}',[ChapterController::class, 'updateStatus']);
});
