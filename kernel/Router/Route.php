<?php

namespace App\Kernel\Router;

class Route
{
    public function __construct(
        private string $uri,
        private string $method,
        private $action
    ) {}

    public function getUri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getAction()
    {
        return $this->action;
    }

    public static function get(string $uri, $action): static
    {
        return new static($uri, 'GET', $action);
    }
}
