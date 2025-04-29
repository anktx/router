<?php

declare(strict_types=1);

namespace Anktx\Router;

final readonly class Route
{
    /**
     * @param callable $handler
     */
    private function __construct(
        public string $method,
        public string $path,
        public mixed $handler,
    ) {}

    public static function get(string $path, callable $handler): self
    {
        return new self('GET', $path, $handler);
    }

    public static function put(string $path, callable $handler): self
    {
        return new self('PUT', $path, $handler);
    }

    public static function post(string $path, callable $handler): self
    {
        return new self('POST', $path, $handler);
    }

    public static function delete(string $path, callable $delete): self
    {
        return new self('DELETE', $path, $delete);
    }

    public static function patch(string $path, callable $handler): self
    {
        return new self('PATCH', $path, $handler);
    }

    public static function head(string $path, callable $handler): self
    {
        return new self('HEAD', $path, $handler);
    }

    public static function options(string $path, callable $handler): self
    {
        return new self('OPTIONS', $path, $handler);
    }

    public static function trace(string $path, callable $handler): self
    {
        return new self('TRACE', $path, $handler);
    }

    public function allowsMethod(string $method): bool
    {
        return strtoupper($method) === $this->method;
    }

    /**
     * @return ?array<string, string>
     */
    public function matchPath(string $url): ?array
    {
        $pattern = $this->pathRegexp();

        if (preg_match($pattern, $url, $matches) === 0) {
            return null;
        }

        return array_filter($matches, static fn($v, $k): bool => !\is_int($k), \ARRAY_FILTER_USE_BOTH);
    }

    private function pathRegexp(): string
    {
        return '#^' . preg_replace('#<(\w+):([^>]+)>#', '(?P<$1>$2)', $this->path) . '$#';
    }
}
