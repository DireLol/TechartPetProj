<?php

namespace App\Kernel\Router;

use App\Kernel\Container\Container;
use App\Kernel\View\ViewInterface;

class Router implements RouterInterface
{
    private array $routes = [
        'GET' => [],
    ];

    public function __construct(
        private ViewInterface $view,
        private Container $container,
    ) {
        $this->initRoutes();
    }

    public function dispatch(string $method, string $uri): void
    {
        $route = $this->findRoute($method, $uri);

        if (! $route) {
            $this->notFound();

            return;
        }

        $action = $route->getAction();
        $params = $this->getRouteParams($route->getUri(), $uri);

        if (is_array($action)) {
            [$controller, $actionMethod] = $action;
            /** @var Controller $controllerInstance */
            $controllerInstance = $this->container->make($controller);
            $controllerInstance->setView($this->view);

            call_user_func_array([$controllerInstance, $actionMethod], $params);
        } else {
            call_user_func_array($action, $params);
        }
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo '404 | Not Found';
        exit;
    }

    private function findRoute(string $method, string $uri): ?Route
    {
        if (! isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $route) {
            $pattern = preg_replace('/{[a-zA-Z0-9_]+}/', '([a-zA-Z0-9_]+)', $route->getUri());
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri)) {
                return $route;
            }
        }

        return null;
    }

    private function initRoutes(): void
    {
        $routes = $this->getRoutes();

        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }

    /**
     * @return Route[]
     */
    private function getRoutes(): array
    {
        return require_once APP_PATH.'/config/routes.php';
    }

    private function getRouteParams(string $routeUri, string $requestUri): array
    {
        $routeParts = explode('/', trim($routeUri, '/'));
        $uriParts = explode('/', trim($requestUri, '/'));

        $params = [];

        foreach ($routeParts as $key => $part) {
            if (preg_match('/^{[a-zA-Z0-9_]+}$/', $part)) {
                $params[] = $uriParts[$key] ?? null;
            }
        }

        return $params;
    }
}
