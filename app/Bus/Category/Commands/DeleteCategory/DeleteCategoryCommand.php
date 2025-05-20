<?php

namespace App\Bus\Category\Commands\DeleteCategory;

final readonly class DeleteCategoryCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
