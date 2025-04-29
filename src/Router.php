<?php

declare(strict_types=1);

namespace Anktx\Router;

use Anktx\Router\Locator\Locator;
use Anktx\Router\Result\MethodNotAllowed;
use Anktx\Router\Result\RouteFound;
use Anktx\Router\Result\RouteNotFound;

final readonly class Router
{
    public function __construct(
        private Locator $locator,
    ) {}

    public function dispatch(string $method, string $url): MethodNotAllowed|RouteFound|RouteNotFound
    {
        $allowedMethods = [];
        $pathMatched = false;

        foreach ($this->locator->routes as $route) {
            $pathParams = $route->matchPath($url);

            if ($pathParams !== null) {
                $pathMatched = true;
                $allowedMethods[] = $route->method;

                if ($route->allowsMethod($method)) {
                    return new RouteFound($route->handler, $pathParams);
                }
            }
        }

        if ($pathMatched) {
            return new MethodNotAllowed($allowedMethods);
        }

        return new RouteNotFound();
    }
}
