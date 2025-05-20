<?php

namespace App\ViewModels;

final readonly class ProductView
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
