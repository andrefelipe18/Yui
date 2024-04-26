<?php

declare(strict_types=1);

namespace Tests\Yui\Helpers;

use PHPUnit\Framework\TestCase;
use Yui\Helpers\Dotenv;

class DotenvTest extends TestCase
{
    public function test_Load()
    {
        file_put_contents('.env.test', "TEST_VAR=hello\n");

        Dotenv::unset();
        Dotenv::load('/home/dre/_PROG/PHP/Yui/Core/.env.test');

        $this->assertEquals('hello', Dotenv::get('TEST_VAR'));

        unlink('/home/dre/_PROG/PHP/Yui/Core/.env.test');
    }

    public function test_Load_Non_Existent_File()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File not found');

        Dotenv::unset();
        Dotenv::load('/non/existent/file');
    }

    public function test_Get()
    {
        file_put_contents('.env.test', "TEST_VAR=hello\n");

        Dotenv::unset();
        Dotenv::load('/home/dre/_PROG/PHP/Yui/Core/.env.test');

        $this->assertEquals('hello', Dotenv::get('TEST_VAR'));

        unlink('/home/dre/_PROG/PHP/Yui/Core/.env.test');
    }

    public function test_Get_Non_Existent_Key()
    {
        file_put_contents('/home/dre/_PROG/PHP/Yui/Core/.env.test', "TEST_VAR=hello\n");

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Key not found');

        Dotenv::unset();
        Dotenv::load('/home/dre/_PROG/PHP/Yui/Core/.env.test');

        Dotenv::get('NON_EXISTENT_KEY');
    }

    public function test_Unset()
    {
        file_put_contents('.env.test', "TEST_VAR=hello\n");

        Dotenv::unset();
        Dotenv::load('/home/dre/_PROG/PHP/Yui/Core/.env.test');

        $this->assertEquals('hello', Dotenv::get('TEST_VAR'));

        Dotenv::unset();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Dotenv not loaded');

        Dotenv::get('TEST_VAR');

        unlink('/home/dre/_PROG/PHP/Yui/Core/.env.test');
    }
}