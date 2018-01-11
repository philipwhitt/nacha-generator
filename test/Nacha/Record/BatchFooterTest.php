<?php

namespace Nacha\Record;

class BatchFooterTest extends \PHPUnit_Framework_TestCase {

	public function testBatchFooter_AllFields() {
		// given
		$batchFooter = (new BatchFooter)
			->setServiceClassCode(200)
			->setEntryAddendaCount(2)
			->setEntryHash('9101298')
			->setTotalDebitAmount('4000')
			->setTotalCreditAmount('95000')
			->setCompanyId('1419871234')
			->setOriginatingDfiId('09991234')
			->setBatchNumber(1);

		$this->assertEquals(94, strlen($batchFooter));
		$this->assertEquals('820000000200091012980000000040000000000950001419871234                         099912340000001', (string)$batchFooter);
	}

	public function testBatchFooter_OptionalFields() {
		// given
		$batchFooter = (new BatchFooter)
			->setServiceClassCode(200)
			->setEntryHash('9101298')
			->setCompanyId('1419871234')
			->setOriginatingDfiId('09991234')
			->setBatchNumber(1);

		$this->assertEquals(94, strlen($batchFooter));
		$this->assertEquals('820000000000091012980000000000000000000000001419871234                         099912340000001', (string)$batchFooter);
	}

}