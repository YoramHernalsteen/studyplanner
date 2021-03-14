<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\WeekController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeWorkController;
use App\Http\Controllers\ExamPlannerController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudySessionController;

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
    //WEEKS
    Route::get('/periods/{period}/week-planner', [WeekController::class, 'index']);
    Route::post('/periods/{period}/week-planner/create', [WeekController::class, 'store']);
    //CLASS
    Route::post('/weeks/{week}/class/create', [ClassController::class, 'store']);
    Route::post('/classes/{week}/{lesson}/edit', [ClassController::class, 'update']);
    Route::post('/classes/{lesson}/delete', [ClassController::class, 'destroy']);
    //HOMEWORK
    Route::post('/weeks/{week}/homework/create', [HomeWorkController::class, 'store']);
    Route::post('/homeworks/{homeWork}/update', [HomeWorkController::class, 'check']);
    Route::post('/homeworks/{week}/{homeWork}/edit', [HomeWorkController::class, 'update']);
    Route::post('/homeworks/{homeWork}/delete', [HomeWorkController::class, 'destroy']);
    //EXAMPLANNER
    Route::get('/periods/{period}/exam-planner', [ExamPlannerController::class, 'index']);
    Route::post('/periods/{period}/exam-planner', [ExamPlannerController::class, 'store']);
    //EXAM
    Route::post('/exam-planner/{examPlanner}/exam/create', [ExamController::class, 'store']);
    Route::post('/exams/{examPlanner}/{exam}/update', [ExamController::class, 'update']);
    Route::post('/exams/{exam}/delete', [ExamController::class, 'destroy']);
    //STUDYSESSION
    Route::post('/exam-planner/{examPlanner}/study-session/create', [StudySessionController::class, 'store']);
    Route::post('/study-sessions/{examPlanner}/{studySession}/update', [StudySessionController::class, 'update']);
    Route::post('/study-sessions/{studySession}/delete', [StudySessionController::class, 'destroy']);
});
