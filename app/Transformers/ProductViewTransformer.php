<?php

namespace App\Transformers;

use App\ViewModels\ProductView;
use Illuminate\Support\Collection;

final readonly class ProductViewTransformer
{
    /** @param array<array{
     *     id: int,
     *     name: string,
     * }> $data
     *
     * @return Collection<ProductView>
     */
    public function transformToCollection(array $data): Collection
    {
        $productViews = new Collection();
        foreach ($data as $product) {
            $productViews->add($this->transform($product));
        }

        return $productViews;
    }

    /** @param array{
     *     id: int,
     *     name: string,
     *  } $data
     */
    public function transform(array $data): ProductView
    {
        return new ProductView(
            id: $data['id'],
            name: $data['name'],
        );
    }
}
