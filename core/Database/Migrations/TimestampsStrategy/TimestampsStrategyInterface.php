<?php

declare(strict_types=1);

namespace Yui\Core\Database\Migrations\TimestampsStrategy;

/**
 * @package Yui\Core\Database\Migrations\TimestampsStrategy
 */
interface TimestampsStrategyInterface
{
    /**
     * Get the column query for the created_at column
     */
    public function getQueryCreatedAtColumn(): string;

    /**
     * Get the column query for the updated_at column
     */
    public function getQueryUpdatedAtColumn(): string;
}
