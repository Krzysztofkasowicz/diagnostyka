<?php

namespace App\ViewModels;

final readonly class CategoryView
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
