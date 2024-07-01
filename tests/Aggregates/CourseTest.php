<?php

namespace Tests\Aggregates;

use App\Aggregates\Course;
use App\StorableEvents\CourseCreated;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{
    public function test_creating_courses()
    {
        $createdByUserId = 1;
        $name = 'Test Course';
        $code = 'TEST';
        $description = 'This is a test course';

        Course::fake()
            ->when(fn(Course $course) => $course->create(
                createdByUserId: $createdByUserId,
                name: $name,
                code: $code,
                description: $description
            ))
            ->assertRecorded(new CourseCreated(
                createdByUserId: $createdByUserId,
                name: $name,
                code: $code,
                description: $description,
            ));
    }

}
