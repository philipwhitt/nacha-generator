<?php

namespace Nacha\Record;

class FileFooterTest extends \PHPUnit_Framework_TestCase {

	public function testFileFooter_AllFields() {
		// given
		$fileFooter = (new FileFooter)
			->setBatchCount(1)
			->setBlockCount(1)
			->setEntryAddendaCount(1)
			->setEntryHash(9101298)
			->setTotalDebits(95000)
			->setTotalCredits(95000);

		$this->assertEquals(94, strlen($fileFooter));
		$this->assertEquals('9000001000001000000010009101298000000095000000000095000                                       ', (string)$fileFooter);
	}

	public function testFileFooter_OptionalFields() {
		// given
		$fileFooter = (new FileFooter)
			->setEntryHash(9101298);

		$this->assertEquals(94, strlen($fileFooter));
		$this->assertEquals('9000000000000000000000009101298000000000000000000000000                                       ', (string)$fileFooter);
	}

}