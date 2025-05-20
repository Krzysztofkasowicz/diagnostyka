<?php

namespace App\Transformers;

use App\ViewModels\CategoryView;
use Illuminate\Support\Collection;

interface CategoryViewTransformerInterface
{
    /** @param array<array{
     *     id: int,
     *     name: string,
     * }> $data
     *
     * @return Collection<CategoryView>
     */
    public function transformToCollection(array $data): Collection;

    /** @param array{
     *     id: int,
     *     name: string,
     *  } $data
     */
    public function transform(array $data): CategoryView;
}
