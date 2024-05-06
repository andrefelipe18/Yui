<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use PDO;
use PDOException;
use Yui\Core\Database\Connection;

/**
 * Class responsible for building raw SQL queries.
 * @package Yui\Core\Database\Builders
 */
class RawBuilder
{	
	/**
	 * Execute a raw SQL query.
	 *
	 * @param string $sql
	 * @param array $params
	 * @return array
	 * @throws PDOException
	 */
	public static function raw(string $sql, array $params = [], ?PDO $testingPdo = null): array
	{
		try {
			$conn = Connection::connect();
			
			if ($testingPdo !== null) {
				$conn = $testingPdo;
			}

			$stmt = $conn->prepare($sql);

			foreach ($params as $key => &$value) {
				$stmt->bindParam($key, $value);
			}

			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage());
		}
	}
}