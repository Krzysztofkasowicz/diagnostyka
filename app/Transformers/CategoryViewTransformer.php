<?php

namespace App\Transformers;

use App\ViewModels\CategoryView;
use Illuminate\Support\Collection;

final readonly class CategoryViewTransformer implements CategoryViewTransformerInterface
{
    public function transformToCollection(array $data): Collection
    {
        $categoryViews = new Collection();
        foreach ($data as $product) {
            $categoryViews->add($this->transform($product));
        }

        return $categoryViews;
    }

    /** @param array{
     *     id: int,
     *     name: string,
     *  } $data
     */
    public function transform(array $data): CategoryView
    {
        return new CategoryView(
            id: $data['id'],
            name: $data['name'],
        );
    }
}
