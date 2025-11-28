<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        $courses = Course::withCount('feedback')
            ->orderBy('name')
            ->paginate(25);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:courses,name'],
        ]);

        Course::create($data);

        return redirect()->route('courses.index')->with('status', 'Course created.');
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:courses,name,' . $course->id],
        ]);

        $course->update($data);

        return redirect()->route('courses.index')->with('status', 'Course updated.');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->feedback()->exists()) {
            return redirect()
                ->route('courses.index')
                ->with('status', 'Cannot delete course with existing feedback.');
        }

        $course->delete();

        return redirect()->route('courses.index')->with('status', 'Course deleted.');
    }
}

