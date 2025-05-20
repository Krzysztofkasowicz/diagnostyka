<?php

namespace App\Bus\Category\Commands\CreateCategory;

use App\DTO\CategoryDTO;

final readonly class CreateCategoryCommand
{
    public function __construct(
        public CategoryDTO $categoryDTO,
    ) {
    }
}
