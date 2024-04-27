<?php

declare(strict_types=1);

namespace Tests\Yui\Helpers;

use Exception;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yui\Core\Helpers\RootFinder;

class RootFinderTest extends TestCase
{
    #[Test]
    public function findRootFolder()
    {
        $path = RootFinder::findRootFolder(__DIR__) . '/.env';
        
        $this->assertFileExists($path);
    }

    #[Test]
    public function findRootFolder_non_existent()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('.env file not found in the project structure.');

        RootFinder::findRootFolder('/non/existent/directory');
    }    
}
