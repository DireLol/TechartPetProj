<?php

namespace App\Kernel\Router;

interface RouterInterface
{
    public function dispatch(string $method, string $uri): void;
}
