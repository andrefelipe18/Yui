<?php

declare(strict_types=1);

namespace Yui\Core\Database\Drivers;

use PDO;
use PDOException;

abstract class Sqlite
{
    public static function connect(string $path): PDO
    {
        try {
            return new PDO("sqlite:$path", null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            return $e;
        }
    }
}