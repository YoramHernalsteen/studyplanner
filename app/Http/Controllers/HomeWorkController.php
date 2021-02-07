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
     * @param Request $request
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
     * @param HomeWork $homeWork
     * @return \Illuminate\Http\Response
     */
    public function show(HomeWork $homeWork)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HomeWork $homeWork
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeWork $homeWork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param HomeWork $homeWork
     * @param Week $week
     * @return void
     */
    public function update(Request $request, Week $week, HomeWork $homeWork)
    {

        if($homeWork->course->period->getUserId() == Auth::id()){
            $request->validate([
                'course'=> 'required|exists:courses,id',
                'date'=>'required|date|before_or_equal:' . $week->getEndDate() . '|after_or_equal:' . $week->getStartDate(),
                'name'=>'required|max:15',
            ]);
            $homeWork->name=request('name');
            $homeWork->date=request('date');
            $homeWork->course_id = request('course');
            $homeWork->save();
            return back();
        } else{
            abort(403);
        }
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
     * @param HomeWork $homeWork
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeWork $homeWork)
    {
        if($homeWork->course->period->getUserId() == Auth::id()){
            $homeWork->delete();
            return back();
        } else{
            abort(403);
        }
    }
}
