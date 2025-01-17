<?php

namespace Tests\Aggregates;

use App\Aggregates\Course;
use App\StorableEvents\CourseCreated;
use App\StorableEvents\CourseRescheduled;
use App\StorableEvents\CourseScheduled;
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

    public function test_schedule_a_course_during_creation()
    {
        $userId = 1;
        $startDate = now();
        $endDate = now()->addDays(7);

        $course = Course::fake()
            ->when(fn(Course $course) => $course->create(
                createdByUserId: $userId,
                name: 'Test Course',
                code: 'TEST',
                description: 'This is a test course',
                startDate: $startDate,
                endDate: $endDate
            ))
            ->assertRecorded([
                new CourseCreated(
                    createdByUserId: $userId,
                    name: 'Test Course',
                    code: 'TEST',
                    description: 'This is a test course',
                ),
                new CourseScheduled(
                    changedByUserId: $userId,
                    startDate: $startDate,
                    endDate: $endDate,
                )
            ])->aggregateRoot();

        $this->assertEquals($startDate, $course->startDate);
        $this->assertEquals($endDate, $course->endDate);
    }

    public function test_schedule_a_course_after_creation()
    {
        $userId = 1;
        $startDate = now();
        $endDate = now()->addDays(7);

        $course = Course::fake()
            ->given([new CourseCreated(
                createdByUserId: $userId,
                name: 'Test Course',
                code: 'TEST',
                description: 'This is a test course',
            )])
            ->when(fn(Course $course) => $course->schedule(
                changedByUserId: $userId,
                startDate: $startDate,
                endDate: $endDate
            ))
            ->assertRecorded(new CourseScheduled(
                changedByUserId: $userId,
                startDate: $startDate,
                endDate: $endDate
            ))->aggregateRoot();

        $this->assertEquals($startDate, $course->startDate);
        $this->assertEquals($endDate, $course->endDate);
    }

    public function test_reschedule_a_course()
    {
        $userId = 1;
        $startDate = now();
        $endDate = now()->addDays(7);
        $newStartDate = $startDate->addDays(4);
        $newEndDate = $startDate->addDays(8);

        $course = Course::fake()
            ->given([new CourseCreated(
                createdByUserId: $userId,
                name: 'Test Course',
                code: 'TEST',
                description: 'This is a test course',
            ), new CourseScheduled(
                changedByUserId: $userId,
                startDate: $startDate,
                endDate: $endDate
            )])
            ->when(fn(Course $course) => $course->schedule(
                changedByUserId: $userId,
                startDate: $newStartDate,
                endDate: $newEndDate
            ))
            ->assertRecorded(new CourseRescheduled(
                changedByUserId: $userId,
                startDate: $newStartDate,
                endDate: $newEndDate
            ))->aggregateRoot();

        $this->assertEquals($newStartDate, $course->startDate);
        $this->assertEquals($newEndDate, $course->endDate);
    }

}
