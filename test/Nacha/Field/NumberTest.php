<?php

namespace Nacha\Field;

class NumberTest extends \PHPUnit_Framework_TestCase {

	public function testPadding() {
		// given
		$nbr = new Number(101, 10);

		// then
		$this->assertEquals('0000000101', (string)$nbr);
	}

	public function testTruncation() {
		// given
		$nbr = new Number(111101, 5);

		// then
		$this->assertEquals('11110', (string)$nbr);
	}

}