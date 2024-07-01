<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class CourseCreationData extends Data
{
    public function __construct(
      public string $name,
        public string $description,
        public string $code,
    ) {}
}
