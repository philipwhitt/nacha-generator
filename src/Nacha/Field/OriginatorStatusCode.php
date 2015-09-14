<?php

namespace Nacha\Field;

class OriginatorStatusCode extends Number {

	const PREPARED_BY_OPERATOR = 0;
	const ORIGINATOR_IS_FI     = 1;
	const ORIGINATOR_IS_EXEMPT = 2; // same as fed
	const ORIGINATOR_IS_FED    = 2; // same as exempt

	public function __construct($value) {
		parent::__construct($value, 2);

		$valid = [
			self::PREPARED_BY_OPERATOR,
			self::ORIGINATOR_IS_FI,
			self::ORIGINATOR_IS_EXEMPT,
			self::ORIGINATOR_IS_FED,
		];

		if (!in_array($value, $valid)) {
			throw new InvalidFieldException('Invalid originator status code "' . $value . '".');
		}
	}

}