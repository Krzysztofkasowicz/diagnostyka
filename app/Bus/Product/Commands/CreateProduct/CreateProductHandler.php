<?php

namespace App\Bus\Product\Commands\CreateProduct;

use Illuminate\Database\ConnectionInterface;
use Throwable;

final readonly class CreateProductHandler
{
    public function __construct(
        private ConnectionInterface $connection,
    ) {
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $this->connection->beginTransaction();

        try {
            $productId = $this->connection
                ->table('products')
                ->insertGetId([
                    'name' => $command->productDTO->name,
                ]);

            if (!empty($command->productDTO->categoryIds)) {
                $pivot = array_map(fn ($categoryId) => [
                    'product_id' => $productId,
                    'category_id' => $categoryId,
                ], $command->productDTO->categoryIds);

                $this->connection
                    ->table('category_product')
                    ->insert($pivot);
            }

            $this->connection->commit();
        } catch (Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }
}
