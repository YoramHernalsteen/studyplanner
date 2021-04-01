<?php

namespace App\Http\Controllers;

use App\Models\ExamPlanner;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamPlannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Period $period
     *
     */
    public function index(Period $period)
    {
        if($period->getUserId() == Auth::id()){

            return view('examPlanner.index', [
                'period'=> $period,
                'examPlanner'=>ExamPlanner::where('period_id', '=', $period->id)->first()
            ]);
        } else{
            abort(403);
        }
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
     * @param Period $period
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Period $period)
    {
        //
        if($period->getUserId() == Auth::id()){
            $examPlanners = ExamPlanner::where('period_id', '=', $period->id)->count();
            if($examPlanners==0){
                $request->validate([
                    'name'=>'required|max:15',
                    'start_date'=>'required|date',
                    'end_date'=>'required|date|after:start_date'
                ]);

                $newExamPlanner = new ExamPlanner();
                $newExamPlanner->setStartDate(request('start_date'));
                $newExamPlanner->setEndDate(request('end_date'));
                $newExamPlanner->setName(request('name'));
                $newExamPlanner->setPeriod($period->id);
                $newExamPlanner->save();
                return redirect('/periods/' . $period->id . '/exam-planner')->with('message', 'New exam-planner ' . $newExamPlanner->getName() . ' created.');
            } else{
                return redirect('/periods/' . $period->id . '/exam-planner')->with('error-message', 'Examplanner already exists for this period!');
            }

        } else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExamPlanner  $examPlanner
     * @return \Illuminate\Http\Response
     */
    public function show(ExamPlanner $examPlanner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamPlanner  $examPlanner
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamPlanner $examPlanner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamPlanner  $examPlanner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamPlanner $examPlanner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamPlanner  $examPlanner
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamPlanner $examPlanner)
    {
        //
    }
}
