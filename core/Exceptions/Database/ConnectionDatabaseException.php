<?php

declare(strict_types=1);

namespace Yui\Core\Exceptions\Database;

use Exception;

class ConnectionDatabaseException extends Exception
{
    public function __construct(string $message = 'Database connection failed', int $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}