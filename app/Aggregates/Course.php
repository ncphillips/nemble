<?php

namespace App\Aggregates;

use App\StorableEvents\CourseCreated;
use Carbon\Carbon;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class Course extends AggregateRoot
{
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
}
