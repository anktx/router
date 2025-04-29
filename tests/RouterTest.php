<?php

declare(strict_types=1);

namespace Anktx\Router\Tests;

use Anktx\Router\Locator\ManualLocator;
use Anktx\Router\Result\MethodNotAllowed;
use Anktx\Router\Result\RouteFound;
use Anktx\Router\Result\RouteNotFound;
use Anktx\Router\Route;
use Anktx\Router\Router;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    public function testDispatch(): void
    {
        $path = '/test';

        $router = new Router(new ManualLocator(
            Route::get($path, static fn() => null),
        ));

        $this->assertInstanceOf(RouteFound::class, $router->dispatch('GET', $path));
        $this->assertInstanceOf(MethodNotAllowed::class, $router->dispatch('POST', $path));
        $this->assertInstanceOf(RouteNotFound::class, $router->dispatch('GET', '/' . uniqid()));
    }
}
