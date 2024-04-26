<?php

declare(strict_types=1);

namespace Tests\Yui\Helpers;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yui\Helpers\Dotenv;

class DotenvTest extends TestCase
{
    #[Test]
    public function load()
    {
        file_put_contents('.env.test', "TEST_VAR=hello\n");

        Dotenv::unset();
        Dotenv::load(path: '/home/dre/_PROG/PHP/Yui/Core/.env.test');

        $this->assertEquals('hello', Dotenv::get('TEST_VAR'));

        unlink('/home/dre/_PROG/PHP/Yui/Core/.env.test');
    }

    #[Test]
    public function load_non_existent_file()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File not found');

        Dotenv::unset();
        Dotenv::load(path: '/non/existent/file');
    }

    #[Test]
    public function get()
    {
        file_put_contents('.env.test', "TEST_VAR=hello\n");

        Dotenv::unset();
        Dotenv::load(path: '/home/dre/_PROG/PHP/Yui/Core/.env.test');

        $this->assertEquals('hello', Dotenv::get('TEST_VAR'));

        unlink('/home/dre/_PROG/PHP/Yui/Core/.env.test');
    }

    #[Test]
    public function get_non_existent_key()
    {
        file_put_contents('/home/dre/_PROG/PHP/Yui/Core/.env.test', "TEST_VAR=hello\n");

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Key not found');

        Dotenv::unset();
        Dotenv::load(path: '/home/dre/_PROG/PHP/Yui/Core/.env.test');

        Dotenv::get('NON_EXISTENT_KEY');
    }

    #[Test]
    public function unset()
    {
        file_put_contents('.env.test', "TEST_VAR=hello\n");

        Dotenv::unset();
        Dotenv::load(path: '/home/dre/_PROG/PHP/Yui/Core/.env.test');

        $this->assertEquals('hello', Dotenv::get('TEST_VAR'));

        Dotenv::unset();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Dotenv not loaded');

        Dotenv::get('TEST_VAR');

        unlink('/home/dre/_PROG/PHP/Yui/Core/.env.test');
    }
}