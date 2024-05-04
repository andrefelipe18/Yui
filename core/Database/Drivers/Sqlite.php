<?php

declare(strict_types=1);

namespace Yui\Core\Database\Drivers;

use PDO;
use PDOException;

class Sqlite
{
    public static function connect(string $path, ?PDO $pdo = null): PDO|PDOException
    {
        try {
            if($pdo === null){
            return new PDO("sqlite:$path", null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
            } else {
                // Simulates a connection attempt to check whether the mock should throw an exception
                $pdo->getAttribute(PDO::ATTR_SERVER_INFO);
            }

            return $pdo;
        } catch (PDOException $e) {
            return $e;
        }
    }
}
