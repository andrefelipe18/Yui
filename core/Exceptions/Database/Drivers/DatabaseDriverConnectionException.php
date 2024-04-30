<?php

declare(strict_types=1);

namespace Yui\Core\Exceptions\Database\Drivers;

use Exception;

class DatabaseDriverConnectionException extends Exception
{
    public function __construct(string $message = 'Database driver connection failed', int $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
