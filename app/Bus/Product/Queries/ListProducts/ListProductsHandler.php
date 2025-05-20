<?php

namespace App\Bus\Product\Queries\ListProducts;

use App\Transformers\ProductViewTransformer;
use App\ViewModels\ProductView;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final readonly class ListProductsHandler
{
    public function __construct(
        private ConnectionInterface $connection,
        private ProductViewTransformer $viewTransformer,
    ) {
    }

    /** @return Collection<ProductView> */
    public function __invoke(ListProductsQuery $query): Collection
    {
        $builder = $this->connection
            ->table('products', 'p')
            ->select('p.id', 'p.name')
        ;

        if ($query->filter->categoryId !== null) {
            $builder
                ->join('category_product', 'p.id', '=', 'category_product.product_id')
                ->where('category_product.category_id', $query->filter->categoryId)
            ;
        }

        $products = $builder
            ->get()
            ->map(fn ($item) => (array) $item)
            ->toArray()
        ;

        return $this->viewTransformer->transformToCollection($products);
    }
}
