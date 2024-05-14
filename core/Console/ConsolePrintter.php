<?php

declare(strict_types=1);

namespace Yui\Core\Console;

/**
 * This class is responsible for printing messages to the console.
 * This class have a fluent interface, so you can chain the methods.
 * @package Yui\Core\Console
 */
class ConsolePrintter
{
	public $message = '';

	private const TEXT_COLORS = [
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

	private const BACKGROUND_COLORS = [
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
		$this->message = '';
	}

	public function title(string $title, ?string $color = null, ?string $backgroundColor = null): self
	{
		$this->message .= $this->formatMessage($title, $color, $backgroundColor, true);

		return $this;
	}

	public function text(string $text, ?string $color = null, ?string $backgroundColor = null): self
	{
		$this->message .= $this->formatMessage($text, $color, $backgroundColor);

		return $this;
	}

	public function breakLine(): self
	{
		$this->message .= "\n";

		return $this;
	}

	private function formatMessage(string $text, ?string $color, ?string $backgroundColor, bool $isTitle = false): string
	{
		$colorCode = $color && $this->colorExists($color) ? self::TEXT_COLORS[$color] : null;
		$backgroundColorCode = $backgroundColor && $this->colorExists($backgroundColor, true) ? self::BACKGROUND_COLORS[$backgroundColor] : null;

		$style = "\033[";

		if ($colorCode) {
			$style .= $colorCode;
		}

		if ($backgroundColorCode) {
			$style .= ';' . $backgroundColorCode;
		}

		if ($isTitle) {
			$style .= ';1';
		}

		$style .= "m{$text}\033[0m\n";

		return $style;
	}

	private function colorExists(string $color, bool $isBackground = false): bool
	{
		return array_key_exists($color, $isBackground ? self::BACKGROUND_COLORS : self::TEXT_COLORS);
	}
}