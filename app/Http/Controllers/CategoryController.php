<?php

namespace App\Http\Controllers;

use App\Bus\Category\Commands\CreateCategory\CreateCategoryCommand;
use App\Bus\Category\Commands\DeleteCategory\DeleteCategoryCommand;
use App\Bus\Category\Commands\UpdateCategory\UpdateCategoryCommand;
use App\Bus\Category\Queries\GetCategory\GetCategoryQuery;
use App\Bus\Category\Queries\ListCategories\ListCategoriesQuery;
use App\DTO\CategoryDTO;
use App\Http\Requests\CategoryRequest;
use Illuminate\Bus\Dispatcher;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CategoryController extends Controller
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
    ) {
    }

    public function index(): JsonResponse
    {
        try {
            $categories = $this->dispatcher->dispatchSync(new ListCategoriesQuery());
        } catch (Throwable $e) {
            return $this->handleException($e->getMessage());
        }

        return response()->json($categories);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $category = $this->dispatcher->dispatchSync(new GetCategoryQuery($id));
        } catch (RecordNotFoundException $e) {
            return $this->handleException($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Throwable $e) {
            return $this->handleException($e->getMessage());
        }

        return response()->json($category);
    }

    public function store(CategoryRequest $request): Response
    {
        try {
            $this->dispatcher->dispatchSync(new CreateCategoryCommand(CategoryDTO::fromRequest($request)));
        } catch (Throwable $e) {
           return $this->handleException($e->getMessage());
        }

        return response()->noContent(Response::HTTP_CREATED);
    }

    public function update(CategoryRequest $request, int $id): Response
    {
        try {
            $this->dispatcher->dispatchSync(new UpdateCategoryCommand(CategoryDTO::fromRequest($request, $id)));
        } catch (RecordNotFoundException $e) {
            return $this->handleException($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Throwable $e) {
            return $this->handleException($e->getMessage());
        }

        return response()->noContent(Response::HTTP_OK);
    }

    public function destroy(int $id): Response
    {
        try {
            $this->dispatcher->dispatchSync(new DeleteCategoryCommand($id));
        } catch (RecordNotFoundException $e) {
            return $this->handleException($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Throwable $e) {
            return $this->handleException($e->getMessage());
        }


        return response()->noContent();
    }

    private function handleException(string $message, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $statusCode);
    }
}
