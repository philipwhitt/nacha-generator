<?php

namespace Nacha;

use Nacha\Field\TransactionCode;
use Nacha\Record\DebitEntry;
use Nacha\Record\CcdEntry;
use Nacha\Record\Addenda;

class BatchTest extends \PHPUnit_Framework_TestCase {

	public function setup() {
		$this->batch = new Batch();
		$this->batch->getHeader()->setBatchNumber(1)
			->setCompanyName('MY BEST COMP')
			->setCompanyDiscretionaryData('INCLUDES OVERTIME')
			->setCompanyId('1419871234')
			->setStandardEntryClassCode('PPD')
			->setCompanyEntryDescription('PAYROLL')
			->setCompanyDescriptiveDate('0602')
			->setEffectiveEntryDate('0112')
			->setOriginatorStatusCode('2')
			->setOriginatingDFiId('01021234');

		$this->debitEntry = (new DebitEntry)
			->setTransactionCode(TransactionCode::CHECKING_DEBIT)
			->setReceivingDfiId('09101298')
			->setCheckDigit(7)
			->setDFiAccountNumber('46479999')
			->setAmount('550.00')
			->setIndividualId('SomePerson1255')
			->setIdividualName('Alex Dubrovsky')
			->setDiscretionaryData('S')
			->setAddendaRecordIndicator(0)
			->setTraceNumber('99936340', 1);

		$this->creditEntry = (new CcdEntry)
			->setTransactionCode(TransactionCode::CHECKING_DEPOSIT)
			->setReceivingDfiId('09101298')
			->setCheckDigit(7)
			->setReceivingDFiAccountNumber('46479999')
			->setAmount('600.00')
			->setReceivingCompanyId('Location 23')
			->setReceivingCompanyName('Best Co 23')
			->setDiscretionaryData('S')
			->setAddendaRecordIndicator(0)
			->setTraceNumber('09936340', 1);
	}

	public function testDebitOnlyBatch() {
		// when
		$this->batch->addEntry($this->debitEntry);

		// then
		$output = (string)$this->batch;

		$this->assertEquals((string)$this->batch->getHeader()->getServiceClassCode(), Batch::DEBITS_ONLY);
		$this->assertEquals(
			"5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n".
			"62709101298746479999         0000055000SomePerson1255 Alex Dubrovsky        S 0999363400000001\n".
			"822500000100091012980000000550000000000000001419871234                         010212340000001", 
			$output
		);
	}

	public function testCreditOnlyBatch() {
		// when
		$this->batch->addEntry($this->creditEntry);

		// then
		$output = (string)$this->batch;

		$this->assertEquals((string)$this->batch->getHeader()->getServiceClassCode(), Batch::CREDITS_ONLY);
		$this->assertEquals(
			"5220MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n".
			"62209101298746479999         0000060000Location 23    Best Co 23            S 0099363400000001\n".
			"822000000100091012980000000000000000000600001419871234                         010212340000001", 
			$output
		);
	}

	public function testEntryWithAddenda() {
		// when
		$this->creditEntry->addAddenda((new Addenda)
			->setPaymentRelatedInformation('Lorem Ipsum'));

		$this->batch->addEntry($this->creditEntry);

		// then
		$output = (string)$this->batch;

		$this->assertEquals((string)$this->batch->getHeader()->getServiceClassCode(), Batch::CREDITS_ONLY);
		$this->assertEquals(
			"5220MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n".
			"62209101298746479999         0000060000Location 23    Best Co 23            S 1099363400000001\n".
			"705Lorem Ipsum                                                                     00010000001\n".
			"822000000200091012980000000000000000000600001419871234                         010212340000001", 
			$output
		);
	}

	public function testMixedBatch() {
		// when
		$this->batch->addEntry($this->creditEntry);
		$this->batch->addEntry($this->debitEntry->setTraceNumber('99936340', 2));

		// then
		$output = (string)$this->batch;

		$this->assertEquals((string)$this->batch->getHeader()->getServiceClassCode(), Batch::MIXED);
		$this->assertEquals(
			"5200MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n".
			"62209101298746479999         0000060000Location 23    Best Co 23            S 0099363400000001\n".
			"62709101298746479999         0000055000SomePerson1255 Alex Dubrovsky        S 0999363400000002\n".
			"820000000200182025960000000550000000000600001419871234                         010212340000001", 
			$output
		);
	}

	public function testFooterValuesFromHeader() {
	    // when
        $this->batch->getHeader()
            ->setOriginatingDFiId('')
            ->setCompanyId('A419871234');

        // then
        $output = (string)$this->batch;

        $this->assertEquals((string)$this->batch->getHeader()->getServiceClassCode(), Batch::MIXED);
        $this->assertEquals(
            "5200MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n".
            "62209101298746479999         0000060000Location 23    Best Co 23            S 0099363400000001\n".
            "62709101298746479999         0000055000SomePerson1255 Alex Dubrovsky        S 0999363400000002\n".
            "82000000020018202596000000055000000000060000A419871234                                 0000001",
            $output
        );
    }

}