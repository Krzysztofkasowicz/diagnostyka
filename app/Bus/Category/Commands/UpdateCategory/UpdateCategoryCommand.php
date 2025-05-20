<?php

namespace App\Bus\Category\Commands\UpdateCategory;

use App\DTO\CategoryDTO;

final readonly class UpdateCategoryCommand
{
    public function __construct(
        public CategoryDTO $categoryDTO,
    ) {
    }
}
