<?php

namespace Nacha\Field;

class AmountTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException Nacha\Field\InvalidFieldException
	 */
	public function testInvalidType() {
		new Amount(10000000000.00); // only accepts $999M
	}

	public function testFloatOperations() {
		// given
		$sec = new Amount(100.99);

		// then
		$this->assertEquals('10099', (string)$sec);
	}

	public function testFloatStringOperations() {
		// given
		$sec = new Amount('100.99');

		// then
		$this->assertEquals('10099', (string)$sec);
	}

}