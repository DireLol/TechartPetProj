<?php
namespace App\Kernel\EnvManager;

interface EnvManagerInterface {
    public function setEnvValue(string $key, string $value): void;

}