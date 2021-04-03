<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamPlanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ExamPlanner $examPlanner)
    {
        if($examPlanner->period->getUserId() == Auth::id()){
            $request->validate([
                'course'=> 'required|exists:courses,id',
                'date'=>'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
            ]);
            $exam = new Exam();
            $exam->exam_planner_id = $examPlanner->id;
            $exam->course_id = request('course');
            $exam->date = request('date');
            $exam->start_time = request('start_time');
            $exam->end_time = request('end_time');
            $exam->save();
            return redirect()->to(url()->previous() . '#exam' . $exam->id)->with('message', 'Exam ' . $exam->course->name . ' added.');
        } else{
            abort(403);
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamPlanner $examPlanner, Exam $exam)
    {
        if($examPlanner->period->getUserId() == Auth::id()){
            $request->validate([
                'course'=> 'required|exists:courses,id',
                'date'=>'required|date|before_or_equal:' . $examPlanner->getEndDate() . '|after_or_equal:' . $examPlanner->getStartDate(),
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
            ]);
            $exam->exam_planner_id = $examPlanner->id;
            $exam->course_id = request('course');
            $exam->date = request('date');
            $exam->start_time = request('start_time');
            $exam->end_time = request('end_time');
            $exam->save();
            return redirect()->to(url()->previous() . '#exam' . $exam->id);
        } else{
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        if($exam->examPlanner->period->getUserId() == Auth::id()){
            $exam->delete();
            return back();
        } else{
            abort(403);
        }
    }
}
