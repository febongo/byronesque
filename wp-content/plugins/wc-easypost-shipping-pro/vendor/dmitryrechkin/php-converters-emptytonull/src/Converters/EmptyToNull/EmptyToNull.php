<?php

declare(strict_types=1);

namespace DmitryRechkin\Converters\EmptyToNull;

class EmptyToNull
{
	/**
	 * Converts empty to null.
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	public function convert($value)
	{
		return empty($value) ? null : $value;
	}
}
