<?php

namespace App\Aggregates;

use App\StorableEvents\CourseCreated;
use App\StorableEvents\CourseScheduled;
use Carbon\Carbon;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class Course extends AggregateRoot
{
    public string $name;
    public string $code;
    public string $description;
    public Carbon|null $startDate = null;
    public Carbon|null $endDate = null;

    public function create(
        int         $createdByUserId,
        string      $name,
        string      $code,
        string      $description,
        Carbon|null $startDate = null,
        Carbon|null $endDate = null
    ): self
    {
        $this->recordThat(new CourseCreated(
            createdByUserId: $createdByUserId,
            name: $name,
            code: $code,
            description: $description,
            startDate: $startDate,
            endDate: $endDate
        ));

        return $this;
    }

    public function schedule(
        int    $changedByUserId,
        Carbon $startDate,
        Carbon $endDate
    ): self
    {
        $this->recordThat(new CourseScheduled(
            changedByUserId: $changedByUserId,
            startDate: $startDate,
            endDate: $endDate
        ));

        return $this;
    }

    protected function handleCourseCreated(CourseCreated $event)
    {
        $this->name = $event->name;
        $this->code = $event->code;
        $this->description = $event->description;
        $this->startDate = $event->startDate;
        $this->endDate = $event->endDate;
    }

    protected function handleCourseScheduled(CourseScheduled $event)
    {
        $this->startDate = $event->startDate;
        $this->endDate = $event->endDate;
    }
}
