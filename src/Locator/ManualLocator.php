<?php

declare(strict_types=1);

namespace Anktx\Router\Locator;

use Anktx\Router\Route;

final readonly class ManualLocator implements Locator
{
    public array $routes;

    public function __construct(
        Route ...$routes,
    ) {
        $this->routes = $routes;
    }
}
