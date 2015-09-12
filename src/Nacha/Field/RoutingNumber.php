<?php

namespace Nacha\Field;

class RoutingNumber extends Number {
	public function __construct($value) {
		parent::__construct($value, 9);

		if (!preg_match('/^[0-9]{9}$/', (string)$value)) {
			throw new InvalidFieldException('Routing "' . $value . '" must be a 9 digit number.');
		}
	}
}
