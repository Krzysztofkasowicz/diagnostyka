<?php

namespace App\Bus\Product\Commands\UpdateProduct;

use App\DTO\ProductDTO;

final readonly class UpdateProductCommand
{
    public function __construct(
        public ProductDTO $productDTO,
    ) {
    }
}
