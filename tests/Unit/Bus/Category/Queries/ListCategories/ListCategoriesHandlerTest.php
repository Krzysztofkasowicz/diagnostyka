<?php

namespace Tests\Unit\Bus\Category\Queries\ListCategories;

use App\Bus\Category\Queries\ListCategories\ListCategoriesHandler;
use App\Enums\CacheKeyEnum;
use App\Transformers\CategoryViewTransformerInterface;
use App\ViewModels\CategoryView;
use Closure;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Mockery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

#[CoversMethod(ListCategoriesHandlerTest::class, 'asd')]
#[CoversClass(ListCategoriesHandler::class)]
class ListCategoriesHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_retrieves_categories_from_cache_when_available(): void
    {
        // Arrange
        $cachedCategoriesData = [
            ['id' => 1, 'name' => 'Category A'],
            ['id' => 2, 'name' => 'Category B'],
        ];
        $expectedCategoryViews = collect([
            new CategoryView(1, 'Category A'),
            new CategoryView(2, 'Category B'),
        ]);

        $cacheStoreMock = Mockery::mock(Store::class);
        $cacheStoreMock->shouldReceive('rememberForever')
            ->with(CacheKeyEnum::CATEGORIES->value, Mockery::type(Closure::class))
            ->once()
            ->andReturn($cachedCategoriesData);

        $cacheFactoryMock = Mockery::mock(Factory::class);
        $cacheFactoryMock->shouldReceive('store')
            ->once()
            ->andReturn($cacheStoreMock);

        $viewTransformerMock = Mockery::mock(CategoryViewTransformerInterface::class);
        $viewTransformerMock->shouldReceive('transformToCollection')
            ->with($cachedCategoriesData)
            ->once()
            ->andReturn($expectedCategoryViews);

        $connectionMock = Mockery::mock(ConnectionInterface::class);

        $handler = new ListCategoriesHandler($connectionMock, $viewTransformerMock, $cacheFactoryMock);

        // Act
        $result = ($handler)();

        // Assert
        $this->assertEquals($expectedCategoryViews, $result);
        $connectionMock->shouldNotHaveReceived('table');
    }

    public function test_it_retrieves_categories_from_database_and_caches_when_not_available_in_cache(): void
    {
        // Arrange
        $databaseCategoriesData = collect([
            (object) ['id' => 3, 'name' => 'Category C'],
            (object) ['id' => 4, 'name' => 'Category D'],
        ]);
        $transformedCategoriesData = [
            ['id' => 3, 'name' => 'Category C'],
            ['id' => 4, 'name' => 'Category D'],
        ];
        $expectedCategoryViews = collect([
            new CategoryView(3, 'Category C'),
            new CategoryView(4, 'Category D'),
        ]);

        $cacheStoreMock = Mockery::mock(Store::class);
        $cacheStoreMock->shouldReceive('rememberForever')
            ->with(CacheKeyEnum::CATEGORIES->value, Mockery::type(Closure::class))
            ->once()
            ->andReturnUsing(function ($key, Closure $callback) {
                return $callback();
            });

        $cacheFactoryMock = Mockery::mock(Factory::class);
        $cacheFactoryMock->shouldReceive('store')
            ->once()
            ->andReturn($cacheStoreMock);

        $queryBuilderMock = Mockery::mock(Builder::class);
        $queryBuilderMock->shouldReceive('select')
            ->with('id', 'name')
            ->once()
            ->andReturnSelf();
        $queryBuilderMock->shouldReceive('get')
            ->once()
            ->andReturn($databaseCategoriesData);

        $connectionMock = Mockery::mock(ConnectionInterface::class);
        $connectionMock->shouldReceive('table')
            ->with('categories')
            ->once()
            ->andReturn($queryBuilderMock);

        $viewTransformerMock = Mockery::mock(CategoryViewTransformerInterface::class);
        $viewTransformerMock->shouldReceive('transformToCollection')
            ->with($transformedCategoriesData)
            ->once()
            ->andReturn($expectedCategoryViews);

        $handler = new ListCategoriesHandler($connectionMock, $viewTransformerMock, $cacheFactoryMock);

        // Act
        $result = ($handler)();

        // Assert
        $this->assertEquals($expectedCategoryViews, $result);
    }
}
