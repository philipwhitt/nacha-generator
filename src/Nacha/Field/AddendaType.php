<?php

namespace Nacha\Field;

class AddendaType extends Number {

	const POS_SHR_MTE    = 02;
	const ADDENDA        = 05;
	const CHANGE_REFUSED = 98;
	const RETURNED       = 99;

	public function __construct($value) {
		$valid = [
			self::POS_SHR_MTE,
			self::ADDENDA,
			self::CHANGE_REFUSED,
			self::RETURNED,
		];

		if (!in_array($value, $valid)) {
			throw new InvalidFieldException('Addenda Type "' . $value . '" is not valid.');
		}

		parent::__construct($value, 2);
	}


}