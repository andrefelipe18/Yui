<?php

declare(strict_types=1);

namespace Yui\Core\Exceptions\Database;

use Exception;

class DatabaseInitializerException extends Exception
{
    public function __construct(string $message = 'Database initializer failed', int $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
