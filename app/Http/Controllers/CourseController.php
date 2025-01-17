<?php

namespace App\Http\Controllers;

use App\Aggregates\Course;
use App\Data\CourseCreationData;
use App\Models\CourseProjection;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        return inertia('Course/Index', [
            'courses' => CourseProjection::all(),
        ]);
    }

    public function create()
    {
        return inertia('Course/Create');
    }

    public function store(CourseCreationData $data)
    {
        $user = auth()->user();

        $uuid = (string)Str::uuid();

        Course::retrieve($uuid)
            ->create(
                createdByUserId: $user->id,
                name: $data->name,
                code: $data->code,
                description: $data->description
            )
            ->persist();

        return redirect()->route('course.index');
    }
}
