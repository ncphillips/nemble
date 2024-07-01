<?php

namespace App\StorableEvents;

use Carbon\Carbon;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CourseCreated extends ShouldBeStored
{
    public function __construct(
        public int         $createdByUserId,
        public string      $name,
        public string      $code,
        public string      $description,
        public Carbon|null $startDate = null,
        public Carbon|null $endDate = null,
    )
    {
    }
}
