<?php

declare(strict_types=1);

namespace DmitryRechkin\NumberParser;

class NumberParser
{
	/**
	 * Parses float value from a give input.
	 *
	 * @param mixed $value
	 * @return float
	 */
	public function parseFloat($value): float
	{
		$number = 0;
		if (is_string($value)) {
			if (function_exists('utf8_decode')) {
				$value = utf8_decode($value);
			}

			$value = preg_replace('/[^\d\.]/i', '', (string)$value);
			if (is_numeric($value)) {
				$number = floatval($value);
			}
		} elseif (is_numeric($value)) {
			$number = $value;
		}

		return round(floatval($number), 2);
	}

	/**
	 * Parses int value from a give input.
	 *
	 * @param mixed $value
	 * @return integer
	 */
	public function parseInt($value): int
	{
		return intval($this->parseFloat($value));
	}
}
