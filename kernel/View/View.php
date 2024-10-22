<?php

namespace App\Kernel\View;

use App\Kernel\Exceptions\ViewNotFoundException;

class View implements ViewInterface
{
    private string $title = 'Галактический вестник';

    public function page(string $name, array $data = []): void
    {
        $viewPath = APP_PATH."/views/pages/$name.php";

        if (! file_exists($viewPath)) {
            throw new ViewNotFoundException("View $name not found");
        }

        extract(['view' => $this]);
        extract($data);
        include_once $viewPath;
    }

    public function component(string $name): void
    {
        $componentPath = APP_PATH."/views/components/$name.php";

        if (! file_exists($componentPath)) {
            echo "Component $name not found";

            return;
        }

        extract(['view' => $this]);
        include_once $componentPath;
    }

    public function getTitle(): string
    {
        return htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
