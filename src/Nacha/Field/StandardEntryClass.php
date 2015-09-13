<?php

namespace Nacha\Field;

class StandardEntryClass extends String {
	public function __construct($value) {
		parent::__construct(strtoupper($value), 3);

		// @todo validate entry class value
	}
}
