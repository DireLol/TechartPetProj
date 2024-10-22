<?php

namespace App\Kernel\Config;

class Config implements ConfigInterface
{
    public function __construct()
    {
        $this->loadEnv();
    }
    
    public function get(string $key, $default = null): mixed
    {
        [$file, $key] = explode('.', $key);

        $configPath = APP_PATH."/config/$file.php";

        if (! file_exists($configPath)) {
            return $default;
        }
        $config = require $configPath;

        return $config[$key] ?? $default;

    }
    private function loadEnv(): void
    {
        $envFilePath = APP_PATH . '/.env';
        if (!file_exists($envFilePath)) {
            return;
        }

        $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}
