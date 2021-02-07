<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Week $week
     *
     */
    public function store(Request $request, Week $week)
    {
        if($week->period->getUserId() == Auth::id()){
            $request->validate([
                'course'=> 'required|exists:courses,id',
                'date'=>'required|date',
                'name'=>'required|max:15',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
            ]);
            $lesson = new Lesson();
            $lesson->week_id = $week->id;
            $lesson->course_id = request('course');
            $lesson->date = request('date');
            $lesson->name = request('name');
            $lesson->start_time = request('start_time');
            $lesson->end_time = request('end_time');
            $lesson->done =false;
            $lesson->save();
            return redirect('/periods/' . $week->period->id . '/week-planner')->with('message', 'Class ' . $lesson->name . ' added.');
        } else{
            abort(403);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        if($lesson->course->period->getUserId() == Auth::id()){
            $lesson->delete();
            return back();
        } else{
            abort(403);
        }
    }
}
