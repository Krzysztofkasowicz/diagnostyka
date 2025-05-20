<?php

namespace App\Bus\Category\Commands\DeleteCategory;

use App\Events\CategoryChangedEvent;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\ConnectionInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

final readonly class DeleteCategoryHandler
{
    public function __construct(
        private ConnectionInterface $connection,
        private Dispatcher $dispatcher,
    ) {
    }

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $deleted = $this->connection
            ->table('categories')
            ->where('id', $command->id)
            ->delete()
        ;

        if (!$deleted) {
            throw new ResourceNotFoundException('Category not found');
        }

        $this->dispatcher->dispatch(new CategoryChangedEvent($command->id));
    }
}
