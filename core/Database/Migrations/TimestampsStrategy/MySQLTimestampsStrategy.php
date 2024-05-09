<?php

declare(strict_types=1);

namespace Yui\Core\Database\Migrations\TimestampsStrategy;

/**
 * @package Yui\Core\Database\Migrations\MySQLTimestampsStrategy
 */
class MySQLTimestampsStrategy implements TimestampsStrategyInterface
{
    /**
     * Get the column query for the created_at column
     */
    public function getQueryCreatedAtColumn(): string
    {
        return 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
    }

    /**
     * Get the column query for the updated_at column
     */
    public function getQueryUpdatedAtColumn(): string
    {
        return 'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';
    }
}
