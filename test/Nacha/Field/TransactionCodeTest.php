<?php

namespace Nacha\Field;

class TransactionCodeTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException Nacha\Field\InvalidFieldException
	 */
	public function testInvalidType() {
		new TransactionCode(40);
	}

	public function testValid() {
		// given
		$sec = new TransactionCode(TransactionCode::SAVINGS_DEPOSIT);

		// then
		$this->assertEquals(TransactionCode::SAVINGS_DEPOSIT, (string)$sec);
	}

}