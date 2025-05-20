<?php

namespace App\Bus\Product\Commands\UpdateProduct;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\RecordNotFoundException;
use Throwable;

final readonly class UpdateProductHandler
{
    public function __construct(
        private ConnectionInterface $connection,
    ) {
    }

    public function __invoke(UpdateProductCommand $command): void
    {
        $this->connection->beginTransaction();

        try {
            $exists = $this->connection
                ->table('products')
                ->where('id', $command->productDTO->id)
                ->exists()
            ;

            if (!$exists) {
                throw new RecordNotFoundException('Product not found');
            }

            if (null !== $command->productDTO->name) {
                $this->connection
                    ->table('products')
                    ->where('id', $command->productDTO->id)
                    ->update([
                        'name' => $command->productDTO->name,
                    ])
                ;
            }

            if (null !== $command->productDTO->categoryIds) {
                $this->connection
                    ->table('category_product')
                    ->where('product_id', $command->productDTO->id)
                    ->delete()
                ;

                if (!empty($command->productDTO->categoryIds)) {
                    $pivot = array_map(fn($categoryId) => [
                        'product_id' => $command->productDTO->id,
                        'category_id' => $categoryId,
                    ], $command->productDTO->categoryIds);

                    $this->connection
                        ->table('category_product')
                        ->insert($pivot)
                    ;
                }
            }

            $this->connection->commit();
        } catch (Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }
}
