<?php

namespace App\Bus\Product\Commands\DeleteProduct;

use Illuminate\Database\ConnectionInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Throwable;

final readonly class DeleteProductHandler
{
    public function __construct(
        private ConnectionInterface $connection,
    ) {
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $this->connection->beginTransaction();

        try {
            $this->connection
                ->table('category_product')
                ->where('product_id', $command->id)
                ->delete();

            $deleted = $this->connection
                ->table('products')
                ->where('id', $command->id)
                ->delete();

            if (!$deleted) {
                throw new ResourceNotFoundException('Product not found');
            }

            $this->connection->commit();

        } catch (Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }
}
