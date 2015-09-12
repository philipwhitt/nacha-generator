<?php

namespace Nacha\Field;

class FileIdModifier extends String {
	public function __construct($value) {
		parent::__construct($value, 1);

		if (!preg_match('/^[A-Z0-9]$/', (string)$value)) {
			throw new InvalidFieldException('File Id Modifier "' . $value . '" must be A-Z 0-9.');
		}
	}
}
