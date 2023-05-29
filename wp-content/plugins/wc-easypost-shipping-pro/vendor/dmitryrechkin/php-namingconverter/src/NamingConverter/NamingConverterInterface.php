<?php

declare(strict_types=1);

namespace DmitryRechkin\NamingConverter;

interface NamingConverterInterface
{
	/**
	 * Converts a given string to a new format.
	 *
	 * @return string
	 */
	public function convert(string $value): string;
}
