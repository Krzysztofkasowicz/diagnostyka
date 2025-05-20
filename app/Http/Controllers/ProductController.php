<?php

namespace App\Http\Controllers;

use App\Bus\Product\Commands\CreateProduct\CreateProductCommand;
use App\Bus\Product\Commands\DeleteProduct\DeleteProductCommand;
use App\Bus\Product\Commands\UpdateProduct\UpdateProductCommand;
use App\Bus\Product\Queries\GetProduct\GetProductQuery;
use App\Bus\Product\Queries\ListProducts\ListProductsQuery;
use App\DTO\FilterDTO;
use App\DTO\ProductDTO;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Bus\Dispatcher;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ProductController extends Controller
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
    ) {
    }

    public function index(FilterRequest $filterRequest): JsonResponse
    {
        try {
            $products = $this->dispatcher->dispatchSync(new ListProductsQuery(FilterDTO::fromRequest($filterRequest)));
        } catch (Throwable $e) {
            return $this->handleException($e->getMessage());
        }

        return response()->json($products);
    }

    public function store(CreateProductRequest $request): Response
    {
        try {
            $this->dispatcher->dispatchSync(new CreateProductCommand(ProductDTO::fromCreateRequest($request)));
        } catch (Throwable $e) {
            return $this->handleException($e->getMessage());
        }

        return response()->noContent(Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->dispatcher->dispatchSync(new GetProductQuery($id));
        } catch (RecordNotFoundException $e) {
            return $this->handleException($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Throwable $e) {
            return $this->handleException($e->getMessage());
        }

        return response()->json($product);
    }

    public function update(UpdateProductRequest $request, int $id): Response
    {
        try {
            $this->dispatcher->dispatchSync(new UpdateProductCommand(ProductDTO::fromUpdateRequest($request, $id)));
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
            $this->dispatcher->dispatchSync(new DeleteProductCommand($id));
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
