<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        return view('periods.index', [
            'user'=> Auth::user(),
            'periods'=> Period::where('user_id', '=', Auth::id())->orderBy('due_date', 'DESC')->get(),

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
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:15|unique:periods,name,NULL,id,user_id,' . Auth::id(),
            'due_date'=>'required|date',
        ]);
        $period = new Period();
        $period->setName(request('name'));
        $period->setUserId(Auth::id());
        $period->setDueDate(request('due_date'));
        $period->save();
        return redirect('/')->with('message', 'New period ' . $period->getName() . ' created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Period  $period
     *
     */
    public function show(Period $period)
    {
        if ( $period->user_id == Auth::id() ) {
            $colors = ['#ffadad', '#ffd6a5', '#fdffb6', '#caffbf', '#A0C4FF','#BDB2FF', '#a0c4ff', '#ffc6ff', '#9bf6ff'];
            return view('periods.show', [
                'user'=> Auth::user(),
                'courses'=> $period->courses,
                'period'=> $period,
                'colors'=>$colors,

            ]);
        }
        abort(403);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function edit(Period $period)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Period  $period
     *
     */
    public function update(Request $request, Period $period)
    {
        if ( $period->user_id == Auth::id()) {
            if(request('name')=== $period->getName()){
                $request->validate([
                    'name' => 'required|max:190',
                    'due_date'=>'required|date',
                ]);
            }else{
                $request->validate([
                    'name' => 'required|unique:periods,name,NULL,id,user_id,' . Auth::id(). '|max:190',
                    'due_date'=>'required|date',
                ]);
            }

            $period->setName(request('name'));
            $period->setDueDate(request('due_date'));
            $period->save();
            return redirect('/')->with('message', $period->getName() . ' was just updated.');
        }
        abort(403);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Period  $period
     *
     */
    public function destroy(Period $period)
    {
        if ( $period->user_id == Auth::id() ) {
            $name = $period->getName();
            $period->delete();
            return redirect('/')->with('message', $name . ' was deleted.');
        }
        abort(403);

    }
}
