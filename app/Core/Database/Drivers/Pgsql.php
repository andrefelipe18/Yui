<?php

declare(strict_types=1);

namespace Yui\Core\Database\Drivers;

use PDO;
use PDOException;

abstract class Pgsql
{
    public static function connect(string $host, string $dbname, string $user, string $pass, string $port, int $timeout = 30): PDO|PDOException
    {
        try {
            $dsn = "pgsql:host=$host;dbname=$dbname;port=$port";
            return new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_TIMEOUT => $timeout
            ]);
        }  catch (PDOException $e) {
            return $e;
        }
    }
}