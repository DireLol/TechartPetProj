<?php
declare(strict_types=1);
namespace App\Kernel\EnvManager;
use App\Kernel\EnvManager\EnvManagerInterface;

class EnvManager implements EnvManagerInterface {
    private array $env = [];

    public function __construct(){
        $this->loadEnv();
    }

    private function loadEnv() : void
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
            $this->setEnvValue(trim($key),trim($value));
        }
    }
    public function setEnvValue(string $key, string $value): void
    {
        if($this->validateEnvKey($key) && $this->validateEnvValue($value)){
            $this->env[$key] = $value;
        }
        else {
            error_log("Невалидное значение для переменной окружения $key");
        }
    }
    public function getEnvValue(string $key): ?string
    {
        return $this->env[$key] ?? null;
    }
    private function validateEnvKey(string $key): bool
    {
        return !empty($key) && is_string($key);
    }
    private function validateEnvValue(string $value):bool
    {
        return !empty($value) && is_string($value);
    }
}