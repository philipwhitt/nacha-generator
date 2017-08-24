<?php

namespace Nacha\Field;

class Number {

	protected $value;
	protected $length;

	/**
	 * Number constructor.
	 * @param int $value
	 * @param $length
	 * @throws InvalidFieldException
	 */
	public function __construct($value, $length) {
		$this->value  = (int)$value;
		$this->length = $length;

		if (!is_int($this->value)) {
			throw new InvalidFieldException('Value "' . $value . '" must be an integer.');
		}

		if (strlen($value) > $length) {
			throw new InvalidFieldException('Length of "' . $value . '" must be '.$length.'.');
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return sprintf("%0{$this->length}d", $this->value);
	}

	/**
	 * @return int
	 */
	public function getValue() {
		return $this->value;
	}

}