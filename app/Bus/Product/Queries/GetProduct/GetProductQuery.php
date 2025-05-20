<?php

namespace App\Bus\Product\Queries\GetProduct;

final readonly class GetProductQuery
{
    public function __construct(
        public int $id,
    ) {
    }
}
