<?php

namespace App\Bus\Category\Queries\GetCategory;

final readonly class GetCategoryQuery
{
    public function __construct(
        public int $id,
    ) {
    }
}
