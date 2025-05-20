<?php

namespace App\Providers;

use App\Bus\Category\Commands\CreateCategory\CreateCategoryCommand;
use App\Bus\Category\Commands\CreateCategory\CreateCategoryHandler;
use App\Bus\Category\Commands\DeleteCategory\DeleteCategoryCommand;
use App\Bus\Category\Commands\DeleteCategory\DeleteCategoryHandler;
use App\Bus\Category\Commands\UpdateCategory\UpdateCategoryCommand;
use App\Bus\Category\Commands\UpdateCategory\UpdateCategoryHandler;
use App\Bus\Category\Queries\GetCategory\GetCategoryHandler;
use App\Bus\Category\Queries\GetCategory\GetCategoryQuery;
use App\Bus\Category\Queries\ListCategories\ListCategoriesHandler;
use App\Bus\Category\Queries\ListCategories\ListCategoriesQuery;
use App\Bus\Product\Commands\CreateProduct\CreateProductCommand;
use App\Bus\Product\Commands\CreateProduct\CreateProductHandler;
use App\Bus\Product\Commands\DeleteProduct\DeleteProductCommand;
use App\Bus\Product\Commands\DeleteProduct\DeleteProductHandler;
use App\Bus\Product\Commands\UpdateProduct\UpdateProductCommand;
use App\Bus\Product\Commands\UpdateProduct\UpdateProductHandler;
use App\Bus\Product\Queries\GetProduct\GetProductHandler;
use App\Bus\Product\Queries\GetProduct\GetProductQuery;
use App\Bus\Product\Queries\ListProducts\ListProductsHandler;
use App\Bus\Product\Queries\ListProducts\ListProductsQuery;
use App\Transformers\CategoryViewTransformer;
use App\Transformers\CategoryViewTransformerInterface;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CategoryViewTransformerInterface::class,
            CategoryViewTransformer::class
        );
    }

    public function boot(): void
    {
        Bus::map([
            GetProductQuery::class => GetProductHandler::class,
            ListProductsQuery::class => ListProductsHandler::class,
            CreateProductCommand::class => CreateProductHandler::class,
            UpdateProductCommand::class => UpdateProductHandler::class,
            DeleteProductCommand::class => DeleteProductHandler::class,
            GetCategoryQuery::class => GetCategoryHandler::class,
            ListCategoriesQuery::class => ListCategoriesHandler::class,
            CreateCategoryCommand::class => CreateCategoryHandler::class,
            UpdateCategoryCommand::class => UpdateCategoryHandler::class,
            DeleteCategoryCommand::class => DeleteCategoryHandler::class,
        ]);
    }
}
