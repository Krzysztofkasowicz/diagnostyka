<?php

namespace App\Bus\Category\Queries\GetCategory;

use App\Enums\CacheKeyEnum;
use App\Transformers\CategoryViewTransformerInterface;
use App\ViewModels\CategoryView;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Database\ConnectionInterface;

final readonly class GetCategoryHandler
{
    public function __construct(
        private ConnectionInterface $connection,
        private CategoryViewTransformerInterface $viewTransformer,
        private Factory $cacheFactory,
    ) {
    }

    public function __invoke(GetCategoryQuery $query): CategoryView
    {
        $cacheKey = sprintf(CacheKeyEnum::CATEGORY_ROW->value, $query->id);
        $category = $this->cacheFactory->store()->rememberForever($cacheKey,
            function () use ($query) {
                return (array) $this->connection
                    ->table('categories')
                    ->select('id', 'name')
                    ->where('id', $query->id)
                    ->first()
                ;
            }
        );

        return $this->viewTransformer->transform($category);
    }
}
