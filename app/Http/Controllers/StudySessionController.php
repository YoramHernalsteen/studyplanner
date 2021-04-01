<?php

namespace App\Http\Controllers;

use App\Models\ExamPlanner;
use App\Models\StudySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudySessionController extends Controller
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
                'hours' => 'required|numeric|min:0',
                'info' => 'required|max:150',
            ]);
            $studySession = new StudySession();
            $studySession->exam_planner_id = $examPlanner->id;
            $studySession->date = request('date');
            $studySession->hours = request('hours');
            $studySession->info = request('info');
            $studySession->course_id = request('course');
            $studySession->save();
            return back()->with('message', 'Study session for ' . $studySession->course->name . ' added.');
        } else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudySession  $studySession
     * @return \Illuminate\Http\Response
     */
    public function show(StudySession $studySession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudySession  $studySession
     * @return \Illuminate\Http\Response
     */
    public function edit(StudySession $studySession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ExamPlanner $examPlanner
     * @param \App\Models\StudySession $studySession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,ExamPlanner $examPlanner, StudySession $studySession)
    {
        if($examPlanner->period->getUserId() == Auth::id()){
            $request->validate([
                'course'=> 'required|exists:courses,id',
                'date'=>'required|date',
                'hours' => 'required|numeric|min:0',
                'info' => 'required|max:150',
            ]);
            $studySession->date = request('date');
            $studySession->hours = request('hours');
            $studySession->info = request('info');
            $studySession->course_id = request('course');
            $studySession->save();
            return back()->with('message', 'Study session for ' . $studySession->course->name . ' updated.');
        } else{
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudySession  $studySession
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudySession $studySession)
    {
        if($studySession->examPlanner->period->getUserId() == Auth::id()){
            $studySession->delete();
            return back();
        } else{
            abort(403);
        }
    }
}
