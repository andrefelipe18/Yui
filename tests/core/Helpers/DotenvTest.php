<?php

declare(strict_types=1);

use Yui\Core\Helpers\Dotenv;

afterEach(function () {
    Dotenv::unset();
    
    if (file_exists('.env.test')) {
        unlink('.env.test');
    }
});

test('load', function () {
    file_put_contents('.env.test', "TEST_VAR=hello\n");

    Dotenv::unset();
    Dotenv::load(path: '/home/dre/_PROG/PHP/Yui/Core/.env.test');

    expect(Dotenv::get('TEST_VAR'))->toEqual('hello');
});

test('load non existent file', function () {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('File not found');

    Dotenv::unset();
    Dotenv::load(path: '/non/existent/file');
});

test('get', function () {
    file_put_contents('.env.test', "TEST_VAR=hello\n");

    Dotenv::unset();
    Dotenv::load(path: '/home/dre/_PROG/PHP/Yui/Core/.env.test');

    expect(Dotenv::get('TEST_VAR'))->toEqual('hello');
});

test('get non existent key', function () {
    file_put_contents('/home/dre/_PROG/PHP/Yui/Core/.env.test', "TEST_VAR=hello\n");

    Dotenv::unset();
    Dotenv::load(path: '/home/dre/_PROG/PHP/Yui/Core/.env.test');

    $key = Dotenv::get('NON_EXISTENT_KEY');

    expect($key)->toEqual('');
});

test('unset', function () {
    file_put_contents('.env.test', "TEST_VAR=hello\n");

    Dotenv::unset();
    Dotenv::load(path: '/home/dre/_PROG/PHP/Yui/Core/.env.test');

    expect(Dotenv::get('TEST_VAR'))->toEqual('hello');

    Dotenv::unset();

    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Dotenv not loaded');

    Dotenv::get('TEST_VAR');
});