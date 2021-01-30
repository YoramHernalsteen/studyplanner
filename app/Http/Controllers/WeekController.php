<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Week;
use Illuminate\Http\Request;

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
        $week = Week::first();
        return view('weeks.index', [
            'period'=> $period,
            'week'=>$week,
        ]);
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
