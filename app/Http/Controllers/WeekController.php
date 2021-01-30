<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Period $period
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Period $period)
    {
        if($period->getUserId() == Auth::id()){
            $week = Week::where([
                ['start_date', '<=' ,date('Y-m-d')],
                ['end_date', '>=', date('Y-m-d')],
                ['period_id', '=', $period->id]
            ])->first();
            if($week !== null){
                $nextDay = date('Y-m-d', strtotime($week->end_date . " +1 day"));;
                $endDay = date('Y-m-d', strtotime($nextDay . " +6 days"));
            } else{
                $nextDay = date('Y-m-d', strtotime( " +1 day"));;
                $endDay = date('Y-m-d', strtotime($nextDay . " +6 days"));
            }

            return view('weeks.index', [
                'period'=> $period,
                'week'=>$week,
                'nextDay'=>$nextDay,
                'endDay'=>$endDay
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
     *
     */
    public function store(Request $request, Period $period)
    {
        if($period->getUserId() == Auth::id()){
            $week = Week::where('period_id', '=', $period->id)->orderByDesc('end_date')->first();
            if($week !== null){
                $request->validate([
                    'name'=>'required|max:15',
                    'start_date'=>'required|date|after:' . $week->end_date,
                    'end_date'=>'required|date|after:start_date|before:' . $period->due_date
                ]);
            } else{
                $request->validate([
                    'name'=>'required|max:15',
                    'start_date'=>'required|date',
                    'end_date'=>'required|date|after:start_date|before:' . $period->due_date
                ]);
            }

            $newWeek = new Week();
            $newWeek->setPeriod($period->id);
            $newWeek->setName(request('name'));
            $newWeek->setStartDate(request('start_date'));
            $newWeek->setEndDate(request('end_date'));
            $newWeek->save();
            return redirect('/periods/' . $period->id . '/week-planner')->with('message', 'New week ' . $newWeek->getName() . ' created.');
        } else{
            abort(403);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function show(Week $week)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function edit(Week $week)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Week $week)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function destroy(Week $week)
    {
        //
    }
}
