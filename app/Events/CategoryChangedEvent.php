<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

final readonly class CategoryChangedEvent
{
    use Dispatchable;

    public function __construct(
        public ?int $id = null,
    ) {
    }
}
