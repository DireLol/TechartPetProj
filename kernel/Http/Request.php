<?php

namespace App\Kernel\Http;

class Request implements RequestInterface
{
    public function __construct(
        public readonly array $get,
        public readonly array $server,
    ) {}

    public static function createFromGlobals(): static
    {
        return new static(
            $_GET,
            $_SERVER
        );
    }

    public function uri(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }
}
