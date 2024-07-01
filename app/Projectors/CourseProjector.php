<?php

namespace App\Projectors;

use App\Models\CourseProjection;
use App\StorableEvents\CourseCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CourseProjector extends Projector
{
    public function onCourseCreated(CourseCreated $event): void
    {
        CourseProjection::create([
            'uuid' => $event->aggregateRootUuid(),
        ]);
    }
}
