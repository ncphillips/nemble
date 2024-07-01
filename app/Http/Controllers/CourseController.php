<?php

namespace App\Http\Controllers;

use App\Models\CourseProjection;

class CourseController extends Controller
{
    public function index()
    {
        return inertia('Course/Index', [
            'courses' => CourseProjection::all(),
        ]);
    }
}
