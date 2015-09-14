<?php

namespace Nacha\Field;

class Amount extends Number {

	public function __construct($value) {
		$float = (float)$value;

		// remove and dots
		$strValue = str_replace('.', '', (string)$float);

		if (strlen($strValue) > 10) {
			throw new InvalidFieldException('Amount "' . $float . '" is too large.');
		}

		parent::__construct($strValue, 10);
	}

}