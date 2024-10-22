<?php

namespace App\Kernel\Controller;

use App\Kernel\Database\DatabaseInterface;
use App\Kernel\View\ViewInterface;

abstract class Controller
{
    private ViewInterface $view;

    private DatabaseInterface $database;

    public function db(): DatabaseInterface
    {
        return $this->database;
    }

    public function setDatabase(DatabaseInterface $database): void
    {
        $this->database = $database;
    }

    public function view(string $name, array $data = []): void
    {
        $this->view->page($name, $data);
    }

    public function setView(ViewInterface $view): void
    {
        $this->view = $view;
    }

    protected function notFound(): void
    {
        http_response_code(404);
        echo '404 | Not Found';
        exit;
        //TODO: Написать ErrorHandler
    }
}
