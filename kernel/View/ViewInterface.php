<?php

namespace App\Kernel\View;

interface ViewInterface
{
    public function page(string $name): void;

    public function component(string $name): void;

    public function getTitle(): string;

    public function setTitle(string $title): void;
}
