<?php

declare(strict_types=1);

use Yui\Core\Helpers\RootFinder;

test('find root folder', function () {
    $path = RootFinder::findRootFolder(__DIR__) . '/.env';

    expect($path)->toBeFile();
});

test('find root folder non existent', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('.env file not found in the project structure.');

    RootFinder::findRootFolder('/non/existent/directory');
});
