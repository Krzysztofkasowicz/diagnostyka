<?php

namespace App\Bus\Category\Commands\CreateCategory;

use App\Events\CategoryChangedEvent;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\ConnectionInterface;

final readonly class CreateCategoryHandler
{
    public function __construct(
        private ConnectionInterface $connection,
        private Dispatcher $dispatcher,
    ) {
    }

    public function __invoke(CreateCategoryCommand $command): void
    {
        $this->dispatcher->dispatch(new CategoryChangedEvent());

        $this->connection
            ->table('categories')
            ->insert(
                [
                    'name' => $command->categoryDTO->name,
                ]
            )
        ;
    }
}
