<?php

function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        throw new Exception("Файл $filePath не найден.");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Пропуск комментариев
        }

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
        }
    }
}

function env($key, $default = null) {
    return $_ENV[$key] ?? $default;
}