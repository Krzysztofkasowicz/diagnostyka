<?php

namespace App\DTO;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

final readonly class ProductDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        /** @var array<int> $categoryIds */
        public array $categoryIds,
    ) {
    }

    public static function fromCreateRequest(CreateProductRequest $request): self
    {
        $validated = $request->validated();

        return new self (
            id: null,
            name: $validated['name'],
            categoryIds: array_map('intval', $validated['category_ids'] ?? [])
        );
    }

    public static function fromUpdateRequest(UpdateProductRequest $request, int $id): self
    {
        $validated = $request->validated();

        return new self (
            id: $id,
            name: $validated['name'] ?? null,
            categoryIds: array_map('intval', $validated['category_ids'] ?? [])
        );
    }
}
