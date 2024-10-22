<?php

namespace App\Kernel\Container;

use App\Kernel\Config\Config;
use App\Kernel\Config\ConfigInterface;
use App\Kernel\Database\Database;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Http\Request;
use App\Kernel\Http\RequestInterface;
use App\Kernel\Router\Router;
use App\Kernel\Router\RouterInterface;
use App\Kernel\View\View;
use App\Kernel\View\ViewInterface;

class Container
{
    public readonly RequestInterface $request;

    public readonly RouterInterface $router;

    public readonly ViewInterface $view;

    public readonly ConfigInterface $config;

    public readonly DatabaseInterface $database;

    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices(): void
    {
        $this->request = Request::createFromGlobals();
        $this->view = new View;
        $this->config = new Config;
        $this->database = new Database($this->config);
        $this->router = new Router($this->view, $this->database);

    }
}
