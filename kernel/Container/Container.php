<?php

namespace App\Kernel\Container;

use App\Kernel\Config\Config;
use App\Kernel\Config\ConfigInterface;
use App\Kernel\EnvManager\EnvManagerInterface;
use App\Kernel\EnvManager\EnvManager;
use App\Kernel\Database\Database;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Http\Request;
use App\Kernel\Http\RequestInterface;
use App\Kernel\Router\Router;
use App\Kernel\Router\RouterInterface;
use App\Kernel\View\View;
use App\Kernel\View\ViewInterface;

use ReflectionClass;
use ReflectionParameter;
use Exception;

class Container
{
    protected array $instances = [];

    public readonly RequestInterface $request;

    public readonly RouterInterface $router;

    public readonly ViewInterface $view;

    public readonly ConfigInterface $config;

    public readonly DatabaseInterface $database;

    public readonly EnvManagerInterface $envManager;

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
        $this->router = new Router($this->view, $this);
        $this->envManager = new EnvManager();

        $this->instances[RequestInterface::class] = $this->request;
        $this->instances[ViewInterface::class] = $this->view;
        $this->instances[ConfigInterface::class] = $this->config;
        $this->instances[DatabaseInterface::class] = $this->database;
        $this->instances[RouterInterface::class] = $this->router;
    }
    public function make(string $class)
    {
        // Если экземпляр уже существует в контейнере
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        // Используем рефлексию для автоматического разрешения зависимостей
        if (!class_exists($class)) {
            throw new Exception("Class {$class} does not exist.");
        }

        $reflectionClass = new ReflectionClass($class);

        // Получаем конструктор, если он существует
        $constructor = $reflectionClass->getConstructor();
        if (!$constructor) {
            // Если у класса нет конструктора, просто создаем экземпляр без аргументов
            return new $class();
        }

        // Разрешаем параметры конструктора
        $parameters = $constructor->getParameters();
        $dependencies = $this->resolveDependencies($parameters);

        // Создаем экземпляр класса с разрешенными зависимостями
        $instance = $reflectionClass->newInstanceArgs($dependencies);
        $this->instances[$class] = $instance; // Кэшируем для дальнейшего использования

        return $instance;
    }

    private function resolveDependencies(array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType() && !$parameter->getType()->isBuiltin()
                ? $this->resolveClass($parameter)
                : $this->resolvePrimitive($parameter);

            $dependencies[] = $dependency;
        }

        return $dependencies;
    }

    private function resolveClass(ReflectionParameter $parameter)
    {
        $name = $parameter->getType()->getName();

        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        return $this->make($name); // Рекурсивно создаем экземпляр зависимости
    }

    private function resolvePrimitive(ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new Exception("Cannot resolve parameter {$parameter->getName()}.");
    }

}
