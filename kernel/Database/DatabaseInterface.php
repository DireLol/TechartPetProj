<?php

namespace App\Kernel\Database;

interface DatabaseInterface
{
    public function prepare(string $sql): \PDOStatement;

    public function query(string $sql): \PDOStatement;
}
