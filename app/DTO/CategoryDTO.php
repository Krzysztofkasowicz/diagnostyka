<?php

namespace App\DTO;

use App\Http\Requests\CategoryRequest;

final readonly class CategoryDTO
{
    public function __construct(
        public ?int $id = null,
        public string $name,
    ) {
    }

    public static function fromRequest(CategoryRequest $request, ?int $id = null): self
    {
        $validated = $request->validated();

        return new self (
            id: $id ?? null,
            name: $validated['name'],
        );
    }
}
