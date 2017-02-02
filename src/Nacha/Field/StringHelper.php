<?php

namespace Nacha\Field;

class StringHelper {

	protected $value;
	protected $length;

	public function __construct($value, $length) {
		$this->value  = substr($value, 0, $length);
		$this->length = $length;

		if (!is_string($value)) {
			throw new InvalidFieldException('Value "' . $value . '" must be an string.');
		}

		if (strlen($value) > 0) {
			foreach (str_split($value) as $char) {
				$ascii = ord($char);

				// ASCII 0-31 + extended ASCII are invalid chars. 
				if ($ascii < 32 || $ascii > 127) {
					throw new InvalidFieldException('Invalid ASCII: ' . ord($value));
				}
			}
		}
	}

	public function __toString() {
		return sprintf('%-' . $this->length . 's', $this->value);
	}
}