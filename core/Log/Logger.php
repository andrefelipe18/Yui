<?php

declare(strict_types=1);

namespace Yui\Core\Log;

use Yui\Core\Helpers\RootFinder;

class Logger
{
	public function framework(string $message): void
	{
		$this->createLogFileIfNotExists();
		$logFile = fopen(RootFinder::findRootFolder(__DIR__) . '/storage/logs/' . 'yui.log', 'a');
		fwrite($logFile, $this->formatMessage($message));
		fclose($logFile);	
	}

	public function frameworkError(string $message): void
	{
		$this->createLogFileIfNotExists();
		$logFile = fopen(RootFinder::findRootFolder(__DIR__) . '/storage/logs/' . 'yui.log', 'a');
		fwrite($logFile, $this->formatErrorMessage($message));
		fclose($logFile);
	}

	public function log(string $message): void
	{
		$this->createLogFileIfNotExists();
		$logFile = fopen(RootFinder::findRootFolder(__DIR__) . '/storage/logs/' . 'app.log', 'a');
		fwrite($logFile, $this->formatMessage($message));
		fclose($logFile);
	}

	public function logError(string $message): void
	{
		$this->createLogFileIfNotExists();
		$logFile = fopen(RootFinder::findRootFolder(__DIR__) . '/storage/logs/' . 'app.log', 'a');
		fwrite($logFile, $this->formatErrorMessage($message));
		fclose($logFile);
	}

	private function formatMessage(string $message): string
	{
		return '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
	}

	private function formatErrorMessage(string $message): string
	{
		return '[' . date('Y-m-d H:i:s') . '] ' . "ERROR: " . $message . PHP_EOL;
	
	}

	private function createLogFileIfNotExists(): void
	{
		$rootFolder = RootFinder::findRootFolder(__DIR__);

		if (!file_exists($rootFolder . '/storage/logs')) {
			mkdir($rootFolder . '/storage/6logs');
		}

		if (!file_exists($rootFolder . '/storage/logs/yui.log')) {
			touch($rootFolder . '/storage/logs/yui.log');
		}

		if (!file_exists($rootFolder . '/storage/logs/app.log')) {
			touch($rootFolder . '/storage/logs/app.log');
		}
	}
}