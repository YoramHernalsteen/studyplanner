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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
