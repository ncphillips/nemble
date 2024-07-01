<?php

namespace App\StorableEvents;

use Carbon\Carbon;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CourseScheduled extends ShouldBeStored
{
    public function __construct(
        public int    $changedByUserId,
        public Carbon $startDate,
        public Carbon $endDate
    )
    {
    }
}
