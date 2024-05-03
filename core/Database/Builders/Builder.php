<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

abstract class Builder
{
    protected function validateNotEmpty(mixed $value, string $message): void
    {
        if (empty($value)) {
            throw new \Exception($message);
        }
    }
}
