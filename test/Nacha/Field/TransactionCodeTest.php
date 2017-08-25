<?php

namespace Nacha\Field;

class TransactionCodeTest extends \PHPUnit_Framework_TestCase {

	private $creditCodes = [21,22,23,24,31,32,33,34,41,42,43,44,51,52,53,54];
	private $debitCodes = [26,27,28,29,36,37,38,39,46,47,48,49,55,56];

	/**
	 * @expectedException \Nacha\Field\InvalidFieldException
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

	public function testAllValidTransactionCodes() {
		$validCodes = array_merge($this->creditCodes,$this->debitCodes);

		foreach($validCodes as $code) {
			$this->assertTrue(TransactionCode::isValid($code));
		}

		$invalidCodes = [1,3,4,5,6,7,8,9,0,10,11,12,13,14,15,16,17,18,19,20,25,30,35,40,45,50,57,58,59,60];
		foreach($invalidCodes as $code) {
			$this->assertFalse(TransactionCode::isValid($code));
		}
	}


	public function testAllCreditTransactionCodesAreRecognized() {
		foreach($this->creditCodes as $code) {
			$this->assertTrue(TransactionCode::isCredit($code));
		}
		foreach($this->debitCodes as $code) {
			$this->assertFalse(TransactionCode::isCredit($code));
		}
	}

	public function testAllDebitTransactionCodesAreRecognized() {
		foreach($this->creditCodes as $code) {
			$this->assertFalse(TransactionCode::isDebit($code));
		}
		foreach($this->debitCodes as $code) {
			$this->assertTrue(TransactionCode::isDebit($code));
		}
	}
}