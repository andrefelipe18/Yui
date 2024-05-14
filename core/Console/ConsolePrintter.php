<?php

declare(strict_types=1);

namespace Yui\Core\Console;

use Yui\Core\Console\Printters\BreakLineConsolePrintter;
use Yui\Core\Console\Printters\ErrorConsolePrintter;
use Yui\Core\Console\Printters\HorizontalDividerConsolePrintter;
use Yui\Core\Console\Printters\InfoConsolePrintter;
use Yui\Core\Console\Printters\LogConsolePrintter;
use Yui\Core\Console\Printters\SuccessConsolePrintter;
use Yui\Core\Console\Printters\TextConsolePrintter;
use Yui\Core\Console\Printters\TitleConsolePrintter;
use Yui\Core\Console\Printters\WarningConsolePrintter;

/**
 * This class is responsible for printing messages to the console.
 * This class have a fluent interface, so you can chain the methods.
 * @package Yui\Core\Console
 * @method Printter text(string $text, ?string $color = null, ?string $backgroundColor = null)
 * @method Printter title(string $text, ?string $color = null, ?string $backgroundColor = null)
 * @method Printter success(string $text)
 * @method Printter warning(string $text)
 * @method Printter error(string $text)
 * @method Printter info(string $text)
 * @method Printter log(string $text)
 * @method Printter horizontalDivider()
 * @method Printter breakLine()
 */
class ConsolePrintter
{
    public $message = '';

    /** @var array<string, mixed> */
    protected array $methods = [];

    public function __construct()
    {
        $this->methods = [
            'text' => new TextConsolePrintter(),
            'title' => new TitleConsolePrintter(),
            'success' => new SuccessConsolePrintter(),
            'warning' => new WarningConsolePrintter(),
            'error' => new ErrorConsolePrintter(),
            'info' => new InfoConsolePrintter(),
            'log' => new LogConsolePrintter(),
            'horizontalDivider' => new HorizontalDividerConsolePrintter(),
            'breakLine' => new BreakLineConsolePrintter(),
        ];
    }

    public function __call(string $name, array $arguments): self
    {
        if (array_key_exists($name, $this->methods)) {
            $this->message .= $this->methods[$name]->$name(...$arguments);
        } else {
            throw new \BadMethodCallException("Method {$name} does not exist.");
        }

        return $this;
    }

    public function print(): void
    {
        echo $this->message;
        $this->message = '';
    }

    public function clear(): void
    {
        echo "\033[2J\033[;H";
    }
}
