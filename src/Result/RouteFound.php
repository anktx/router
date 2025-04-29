<?php

declare(strict_types=1);

namespace Anktx\Router\Result;

final readonly class RouteFound
{
    /**
     * @param callable              $handler
     * @param array<string, string> $pathParams
     */
    public function __construct(
        public mixed $handler,
        public array $pathParams,
    ) {}
}
