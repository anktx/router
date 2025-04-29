<?php

declare(strict_types=1);

namespace Anktx\Router\Result;

final readonly class MethodNotAllowed
{
    /**
     * @param string[] $allowedMethods
     */
    public function __construct(
        public array $allowedMethods,
    ) {}
}
