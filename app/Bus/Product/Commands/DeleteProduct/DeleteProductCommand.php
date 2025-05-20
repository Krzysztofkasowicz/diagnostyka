<?php

namespace App\Bus\Product\Commands\DeleteProduct;

final readonly class DeleteProductCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
