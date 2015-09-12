<?php

namespace Nacha\Record;

class DebitEntryTest extends \PHPUnit_Framework_TestCase {

	public function testEntry_AllFields() {
		// given
		$entry = (new DebitEntry)
			->setRecordTypeCode(6)
			->setTransactionCode(27)
			->setReceivingDfiId('09101298')
			->setCheckDigit(7)
			->setDFiAccountNumber('46479999')
			->setAmount('55000')
			->setIndividualId('SomePerson1255')
			->setIdividualName('Alex Dubrovsky')
			->setDiscretionaryData('S')
			->setAddendaRecordIndicator(0)
			->setTraceNumber('99936340000015');

		$this->assertEquals(94, strlen($entry));
		$this->assertEquals('62709101298746479999         0000055000SomePerson1255 Alex Dubrovsky        S 0099936340000015', (string)$entry);
	}

	public function testEntry_OptionalFields() {
		// given
		$entry = (new DebitEntry)
			->setRecordTypeCode(6)
			->setTransactionCode(27)
			->setReceivingDfiId('09101298')
			->setCheckDigit(7)
			->setDFiAccountNumber('46479999')
			->setAmount('55000')
			->setIdividualName('Alex Dubrovsky')
			->setAddendaRecordIndicator(0)
			->setTraceNumber('99936340000015');

		$this->assertEquals(94, strlen($entry));
		$this->assertEquals('62709101298746479999         0000055000               Alex Dubrovsky          0099936340000015', (string)$entry);
	}

}