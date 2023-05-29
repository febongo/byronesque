<?php

declare(strict_types=1);

namespace DmitryRechkin\NamingConverter;

class CamelCaseConverter implements NamingConverterInterface
{
	/**
	 * Converts a given string to a new format.
	 *
	 * @return string
	 */
	public function convert(string $value): string
	{
		$newValue = '';
		$valueParts = explode('_', $value);
		foreach ($valueParts as $keyPart) {
			$keyPart = strtolower($keyPart);
			if (false === empty($newValue)) {
				$keyPart = ucfirst($keyPart);
			}
			$newValue .= $keyPart;
		}

		return $newValue;
	}
}
