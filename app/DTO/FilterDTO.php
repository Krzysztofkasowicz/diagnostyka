<?php

namespace App\DTO;

use App\Http\Requests\FilterRequest;

final readonly class FilterDTO
{
    public function __construct(
        public ?int $categoryId = null,
    ) {
    }

    public static function fromRequest(FilterRequest $filterRequest): self
    {
        return new self (
            categoryId: $filterRequest->categoryId,
        );
    }
}
