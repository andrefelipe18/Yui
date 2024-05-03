<?php

declare(strict_types=1);

namespace Yui\Core\Database\Drivers;

use PDO;
use PDOException;

class Mysql
{
    public static function connect(string $host, string $dbname, string $user, string $pass, string $port, ?int $timeout = 30, ?PDO $pdo = null): PDO|PDOException
    {
        try {
            if ($pdo === null) {
                $dsn = "mysql:host={$host};port={$port};dbname={$dbname}";
                $pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_TIMEOUT => $timeout
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
