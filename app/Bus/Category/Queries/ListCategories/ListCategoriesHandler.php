<?php

namespace App\Bus\Category\Queries\ListCategories;

use App\Enums\CacheKeyEnum;
use App\Transformers\CategoryViewTransformerInterface;
use App\ViewModels\CategoryView;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Collection;

final readonly class ListCategoriesHandler
{
    public function __construct(
        private ConnectionInterface $connection,
        private CategoryViewTransformerInterface $viewTransformer,
        private Factory $cacheFactory,
    )
    {
    }

    /** @return Collection<CategoryView> */
    public function __invoke(): Collection
    {
        $categories = $this->cacheFactory->store()->rememberForever(CacheKeyEnum::CATEGORIES->value,
            function () {
                return $this->connection
                    ->table('categories')
                    ->select('id', 'name')
                    ->get()
                    ->map(fn ($item) => (array) $item)
                    ->toArray()
                ;
            }
        );

        return $this->viewTransformer->transformToCollection($categories);
    }
}
