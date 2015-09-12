<?php

namespace Nacha\Field;

class NumberTest extends \PHPUnit_Framework_TestCase {

	public function testPadding() {
		// given
		$nbr = new Number(101, 10);

		// then
		$this->assertEquals('0000000101', (string)$nbr);
	}

}