<?php

namespace App\Projectors;

use App\Models\CourseProjection;
use App\StorableEvents\CourseCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CourseProjector extends Projector
{
    public function onCourseCreated(CourseCreated $event): void
    {

        $attributes= [
            'uuid' => $event->aggregateRootUuid(),
            'name' => $event->name,
            'description' => $event->description,
            'code' => $event->code,
            'start_date' => $event->startDate,
            'end_date' => $event->endDate,
        ];

        if (CourseProjection::query()->where('uuid', $event->aggregateRootUuid())->exists()) {
            CourseProjection::where('uuid', $event->aggregateRootUuid())->update($attributes);
        } else {
            CourseProjection::create($attributes);
        }

    }
}
