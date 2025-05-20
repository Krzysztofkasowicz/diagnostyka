<?php

namespace App\Bus\Product\Queries\GetProduct;

use App\Transformers\ProductViewTransformer;
use App\ViewModels\ProductView;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\RecordNotFoundException;

final readonly class GetProductHandler
{
    public function __construct(
        private ConnectionInterface $connection,
        private ProductViewTransformer $viewTransformer,
    ) {
    }

    public function __invoke(GetProductQuery $query): ProductView
    {
        $product = (array) $this->connection
            ->table('products')
            ->select('id', 'name')
            ->where('id', $query->id)
            ->first()
        ;

        if (!$product) {
            throw new RecordNotFoundException("Product not found");
        }

        return $this->viewTransformer->transform($product);
    }
}
