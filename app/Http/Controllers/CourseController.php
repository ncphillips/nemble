<?php

namespace App\Http\Controllers;

use App\Aggregates\Course;
use App\Models\CourseProjection;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        return inertia('Course/Index', [
            'courses' => CourseProjection::all()->map(function (CourseProjection $projection) {
                $course = Course::retrieve($projection->uuid);

                return [
                    'uuid' => $projection->uuid,
                    'name' => $course->name,
                    'description' => $course->description,
                    'code' => $course->code,
                ];
            }),
        ]);
    }

    public function create()
    {
        return inertia('Course/Create');
    }

    public function store()
    {
        $user = auth()->user();
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'code' => 'required',
        ]);

        $uuid = (string)Str::uuid();

        Course::retrieve($uuid)
            ->create(
                $user->id,
                $data['name'],
                $data['description'],
                $data['code']
            )
            ->persist();

        return redirect()->route('course.index');
    }
}
