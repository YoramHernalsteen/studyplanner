<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class ChapterController extends Controller
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
     *
     * @param Course $course
     *
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'name'=>'required|max:190',
            'pages'=>'required|numeric|min:0'
        ]);
        $chapter = new Chapter();
        $chapter->setStatus('not-started');
        $chapter->setPages(request('pages'));
        $chapter->setName(request('name'));
        $chapter->setCourse($course->id);
        $chapter->save();
        if(request('action_url')){
            return redirect(request('action_url'))->with('message', 'New chapter ' . $chapter->getName() . ' added.');
        }
        return redirect('/periods/' . $course->period->id)->with('message', 'New chapter added for: ' . $course->getName());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function show(Chapter $chapter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function edit(Chapter $chapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chapter $chapter)
    {
        //
    }

    public function updateStatus(Request $request, Chapter $chapter)
    {
        $request->validate([
            'status' => 'required|in:not-started,busy,done',
        ]);
        if(request('action_url')){

        }
        $chapter->setStatus(request('status'));
        $chapter->save();
        $course = $chapter->course;
        if(request('action_url')){
            return redirect(request('action_url'))->with('message', 'Status for ' . $chapter->getName() . ' set to ' . $chapter->getStatus());
        }
        return redirect('/periods/' . $course->period->id)->with('message', 'Status for ' . $chapter->getName() . ' set to ' . $chapter->getStatus());
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chapter $chapter)
    {
        //
    }
}
