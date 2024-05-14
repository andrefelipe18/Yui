<?php

declare(strict_types=1);

namespace Yui\Core\Console;

/**
 * This class is responsible for printing messages to the console.
 * This class have a fluent interface, so you can chain the methods.
 * @package Yui\Core\Console
 */
class ConsolePrinter
{
	public $message;

	# Text Colors           Code
	# ---------------------------
	# Black                 0;30
	# White                 1;37
	# Dark Grey             1;30
	# Red                   0;31
	# Green                 0;32
	# Brown                 0;33
	# Yellow                1;33
	# Blue                  0;34
	# Magenta               0;35
	# Cyan                  0;36
	# Light Cyan            1;36
	# Light Grey            0;37
	# Light Red             1;31
	# Light Green           1;32
	# Light Blue            1;34
	# Light Magenta         1;35
	public $textColors = [
		'black' => '0;30',
		'white' => '1;37',
		'dark_grey' => '1;30',
		'red' => '0;31',
		'green' => '0;32',
		'brown' => '0;33',
		'yellow' => '1;33',
		'blue' => '0;34',
		'magenta' => '0;35',
		'cyan' => '0;36',
		'light_cyan' => '1;36',
		'light_grey' => '0;37',
		'light_red' => '1;31',
		'light_green' => '1;32',
		'light_blue' => '1;34',
		'light_magenta' => '1;35',
	];

	# Background Colors     Code
	# ---------------------------
	# Black                 40
	# Red                   41
	# Green                 42
	# Yellow                43
	# Blue                  44
	# Magenta               45
	# Cyan                  46
	# Light Grey            47
	public $backgroundColors = [
		'black' => '40',
		'red' => '41',
		'green' => '42',
		'yellow' => '43',
		'blue' => '44',
		'magenta' => '45',
		'cyan' => '46',
		'light_grey' => '47',
	];

	public function print(): void
	{
		echo $this->message;
	}

	public function text(string $text, ?string $color = null, ?string $backgroundColor = null, ?bool $bold = false): ConsolePrinter
	{
		$this->message = "\033[";

		if ($bold) {
			$this->message .= $this->setBold();
		}

		if ($color) {
			$this->message .= $this->setTextColor($color);
		}

		if ($backgroundColor) {
			$this->message .= $this->setBackgroundColor($backgroundColor);
		}

		$this->message .= 'm' . " {$text} " . "\033[0m";

		return $this;
	}

	private function setTextColor(string $color): string
	{
		if ($color === null) {
			return '';
		}

		$this->checkColor($color);

		return $this->textColors[$color] . ';';
	}

	private function setBackgroundColor(string $color): string
	{
		if ($color === null) {
			return '';
		}

		$this->checkColor($color);

		return $this->backgroundColors[$color] . ';';
	}

	private function checkColor(string $color): void
	{
		if (!array_key_exists($color, $this->textColors)) {
			throw new \Exception("Color {$color} does not exist.");
		}
	}

	private function setBold(): string
	{
		return '1;';
	}
}
