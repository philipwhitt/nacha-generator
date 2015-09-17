<?php

namespace Nacha\Field;

class String {

	protected $value;
	protected $length;

	public function __construct($value, $length) {
		$this->value  = substr($value, 0, $length);
		$this->length = $length;

		if (!is_string($value)) {
			throw new InvalidFieldException('Value "' . $value . '" must be an string.');
		}

		// ASCII 0-31 are invalid chars
		if (strlen($value) > 0) {
			foreach (str_split($value) as $char) {
				if (ord($char) < 32) {
					throw new InvalidFieldException('Invalid ASCII: ' . ord($value));
				}
			}
		}
	}

	public function __toString() {
		return sprintf('%-' . $this->length . 's', $this->value);
	}
}