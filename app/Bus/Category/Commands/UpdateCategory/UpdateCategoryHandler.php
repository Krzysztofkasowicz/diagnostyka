<?php

namespace App\Bus\Category\Commands\UpdateCategory;

use App\Events\CategoryChangedEvent;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\RecordNotFoundException;

final readonly class UpdateCategoryHandler
{
    public function __construct(
        private ConnectionInterface $connection,
        private Dispatcher $dispatcher,
    ) {
    }

    public function __invoke(UpdateCategoryCommand $command): void
    {
        $updated = $this->connection
            ->table('categories')
            ->where('id', $command->categoryDTO->id)
            ->update([
                'name' => $command->categoryDTO->name,
            ])
        ;

        if (!$updated) {
            throw new RecordNotFoundException('Category not found');
        }

        $this->dispatcher->dispatch(new CategoryChangedEvent($command->categoryDTO->id));
    }
}
