<?php

namespace App\Listeners;

use App\Enums\CacheKeyEnum;
use App\Events\CategoryChangedEvent;
use Illuminate\Contracts\Cache\Factory;

final readonly class CategoryCacheInvalidateListener
{
    public function __construct(
        private Factory $cacheFactory,
    ) {
    }

    public function handle(CategoryChangedEvent $event): void
    {
        if ($event->id) {
            $this->cacheFactory->store()->forget(sprintf(CacheKeyEnum::CATEGORY_ROW->value, $event->id));
        }

        $this->cacheFactory->store()->forget(CacheKeyEnum::CATEGORIES->value);
    }
}
