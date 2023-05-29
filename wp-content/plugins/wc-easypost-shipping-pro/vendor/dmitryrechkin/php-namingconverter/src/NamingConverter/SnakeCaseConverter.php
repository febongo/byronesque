<?php

declare(strict_types=1);

namespace DmitryRechkin\NamingConverter;

class SnakeCaseConverter implements NamingConverterInterface
{
	/**
	 * Converts a given string to a new format.
	 *
	 * @return string
	 */
	public function convert(string $value): string
	{
		$newValue = preg_replace('/(?<=\\w)([A-Z]|([0-9]+))/', '_$1', $value);
		$newValue = preg_replace('/_+/', '_', $newValue);
		$newValue = strtolower($newValue);

		return $newValue;
	}
}
