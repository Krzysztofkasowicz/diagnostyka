<?php

namespace App\Bus\Product\Queries\ListProducts;

use App\DTO\FilterDTO;

final readonly class ListProductsQuery
{
    public function __construct(
        public FilterDTO $filter,
    ) {
    }
}
