<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if ($course->period->user_id == Auth::id()) {
            $request->validate([
                'name' => 'required|max:15|unique:chapters,name,NULL,id,course_id,' . $course->id,
                'pages' => 'required|numeric|min:0'
            ]);
            $chapter = new Chapter();
            $chapter->setStatus('not-started');
            $chapter->setPages(request('pages'));
            $chapter->setName(request('name'));
            $chapter->setCourse($course->id);
            $chapter->save();
            if (request('action_url')) {
                return redirect(request('action_url'))->with('message', 'New chapter ' . $chapter->getName() . ' added.');
            }
            return redirect('/periods/' . $course->period->id)->with('message', 'New chapter added for: ' . $course->getName());
        }
        abort(403);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Chapter $chapter
     * @return \Illuminate\Http\Response
     */
    public function show(Chapter $chapter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Chapter $chapter
     * @return \Illuminate\Http\Response
     */
    public function edit(Chapter $chapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chapter $chapter
     *
     */
    public function update(Request $request, Chapter $chapter)
    {
        if ($chapter->course->period->user_id == Auth::id()) {
            if (request('name') === $chapter->name) {
                $request->validate([
                    'name' => 'required|max:15',
                    'pages' => 'required|numeric|min:0'
                ]);
            } else {
                $request->validate([
                    'name' => 'required|max:15|unique:chapters,name,NULL,id,course_id,' . $chapter->course->id,
                    'pages' => 'required|numeric|min:0'
                ]);
            }
            $chapter->setPages(request('pages'));
            $chapter->setName(request('name'));
            $chapter->save();
            return redirect('/courses/show/' . $chapter->course->id)->with('message', 'Chapter ' . $chapter->getName() . ' was updated.');
        }
        abort(403);
    }


    public function updateStatus(Request $request, Chapter $chapter)
    {
        if ($chapter->course->period->user_id == Auth::id()) {
            $request->validate([
                'status' => 'required|in:not-started,busy,done',
            ]);
            $chapter->setStatus(request('status'));
            $chapter->save();
            $course = $chapter->course;
            if (request('action_url')) {
                return redirect(request('action_url'))->with('message', 'Status for ' . $chapter->getName() . ' set to ' . $chapter->getStatus());
            }
            return redirect('/periods/' . $course->period->id)->with('message', 'Status for ' . $chapter->getName() . ' set to ' . $chapter->getStatus());
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Chapter $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chapter $chapter)
    {
        if ( $chapter->course->period->id == Auth::id() ) {
            $courseID = $chapter->course->id;
            $name = $chapter->getName();
            $chapter->delete();
            return redirect('/courses/show/' . $courseID)->with('message', $name . ' was deleted.');
        }

    }
}
