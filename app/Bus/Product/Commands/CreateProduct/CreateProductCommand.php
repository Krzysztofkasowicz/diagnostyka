<?php

namespace App\Bus\Product\Commands\CreateProduct;

use App\DTO\ProductDTO;

final readonly class CreateProductCommand
{
    public function __construct(
        public ProductDTO $productDTO
    ) {
    }
}
