<?php

declare(strict_types=1);

namespace Anktx\Router\Tests;

use Anktx\Router\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class RouteTest extends TestCase
{
    #[DataProvider('methodFactoryProvider')]
    public function testStaticConstructors(string $methodName, string $expectedMethod): void
    {
        $route = Route::$methodName('/', static fn() => null);
        $this->assertSame($expectedMethod, $route->method);
    }

    public static function methodFactoryProvider(): \Generator
    {
        yield ['get', 'GET'];

        yield ['put', 'PUT'];

        yield ['post', 'POST'];

        yield ['delete', 'DELETE'];

        yield ['patch', 'PATCH'];

        yield ['head', 'HEAD'];

        yield ['options', 'OPTIONS'];

        yield ['trace', 'TRACE'];
    }

    #[DataProvider('methodProvider')]
    public function testAllowsMethod(string $method, bool $expected): void
    {
        $route = Route::get('/', static fn() => null);

        $this->assertSame($expected, $route->allowsMethod($method));
    }

    public static function methodProvider(): \Generator
    {
        yield ['GET', true];

        yield ['get', true];

        yield ['POST', false];
    }

    #[DataProvider('pathProvider')]
    public function testMatchPath(string $routePattern, string $path, mixed $expected): void
    {
        $route = Route::get($routePattern, static fn() => null);

        $this->assertSame($expected, $route->matchPath($path));
    }

    public static function pathProvider(): \Generator
    {
        yield ['/path', '/path', []];

        yield ['/profile/about', '/profile/about', []];

        yield ['/user/<id:\d+>', '/user/123', ['id' => '123']];

        yield ['/user/<id:\d+>/<age:\d+>', '/user/123/44', ['id' => '123', 'age' => '44']];

        yield ['/user/<name:\w+>', '/user/Petya', ['name' => 'Petya']];
    }
}
