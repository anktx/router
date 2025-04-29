<?php

declare(strict_types=1);

namespace Anktx\Router\Locator;

use Anktx\Router\Route;

interface Locator
{
    /**
     * @var Route[]
     */
    public array $routes { get; }
}
