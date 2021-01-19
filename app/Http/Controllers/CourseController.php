<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Period $period)
    {
        $request->validate([
            'name' => 'required|unique:courses|max:190',
            'exam_form'=>'required|max:190',
        ]);
        $course = new Course();
        $course->setName(request('name'));
        $course->period_id = $period->id;
        $course->setExamForm(request('exam_form'));
        $course->save();
        return redirect('/periods/' . $period->id)->with('message', 'new course: ' . $course->getName());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     *
     */
    public function show(Course $course)
    {
        return view('courses.show', [
           'course'=>$course,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     *
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|unique:courses|max:190',
            'exam_form'=>'required|max:190',
        ]);
        $course->setName(request('name'));
        $course->setExamForm(request('exam_form'));
        $course->save();
        return redirect('/periods/' . $course->period->id)->with('message', $course->getName() . ' was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     *
     */
    public function destroy(Course $course)
    {
        $name = $course->getName();
        $period = $course->period->id;
        $course->delete();
        return redirect('/periods/' . $period)->with('message',$name . ' was deleted.');
    }
}
