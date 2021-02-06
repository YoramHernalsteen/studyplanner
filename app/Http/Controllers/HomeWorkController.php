<?php

namespace App\Http\Controllers;

use App\Models\HomeWork;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeWorkController extends Controller
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
        if(Auth::id() == $week->period->getUserId()){
            $request->validate([
                'course'=> 'required|exists:courses,id',
                'date'=>'required|date',
                'name'=>'required|max:15',
            ]);
            $homeWork = new HomeWork();
            $homeWork->course_id = request('course');
            $homeWork->week_id = $week->id;
            $homeWork->date = request('date');
            $homeWork->name = request('name');
            $homeWork->done = false;
            $homeWork->save();
            return redirect('/periods/' . $week->period->id . '/week-planner')->with('message', 'Homework added');

        } else{
            abort(403);
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeWork  $homeWork
     * @return \Illuminate\Http\Response
     */
    public function show(HomeWork $homeWork)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeWork  $homeWork
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeWork $homeWork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeWork  $homeWork
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeWork $homeWork)
    {
        //
    }

    public function check(HomeWork $homeWork){
        if(Auth::id() == $homeWork->course->period->getUserId()){
            if($homeWork->done == true){
                $homeWork->done =false;
            } else{
                $homeWork->done=true;
            }
            $homeWork->save();
            return redirect('/periods/' . $homeWork->course->period->id  . '/week-planner')->with('message', 'Homework status updated');
        } else{
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeWork  $homeWork
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeWork $homeWork)
    {
        //
    }
}
