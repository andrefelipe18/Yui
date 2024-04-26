<?php

declare(strict_types=1);

namespace Yui\Core\Database\Drivers;

use PDO;
use PDOException;

abstract class Mysql
{
    public static function connect(string $host, string $dbname, string $user, string $pass, string $port): PDO
    {
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
            return new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }  catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }
}