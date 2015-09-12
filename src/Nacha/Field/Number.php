<?php

namespace Nacha\Field;

class Number {

	protected $value;
	protected $length;

	public function __construct($value, $length) {
		$this->value  = (int)$value;
		$this->length = $length;

		if (!is_int($this->value)) {
			throw new InvalidFieldException('Value "' . $value . '" must be an integer.');
		}
	}
	
	public function __toString() {
		return sprintf('%0' . $this->length . 'd', $this->value);
	}

}