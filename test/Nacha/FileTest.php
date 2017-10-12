<?php

namespace Nacha;

use Nacha\Record\DebitEntry;
use Nacha\Record\CcdEntry;
use Nacha\Record\Addenda;
use Nacha\Field\TransactionCode;

class FileTest extends \PHPUnit_Framework_TestCase {

	public function setup() {
		$this->file = new File();
		$this->file->getHeader()->setPriorityCode(1)
			->setImmediateDestination('051000033')
			->setImmediateOrigin('059999997')
			->setFileCreationDate('060210')
			->setFileCreationTime('2232')
			->setFormatCode('1')
			->setImmediateDestinationName('ImdDest Name')
			->setImmediateOriginName('ImdOriginName')
			->setReferenceCode('Reference');
	}

	public function testBatchesEntryCount() {
		// when
		$this->file->addBatch($this->getBatch());
		$this->file->addBatch($this->getBatch());

		// then
		$this->assertEquals('0000001', (string)$this->file->getBatches()[0]->getHeader()->getBatchNumber());
		$this->assertEquals('0000002', (string)$this->file->getBatches()[1]->getHeader()->getBatchNumber());
	}

	public function testBatchesAndEntriesNoBlockFill() {
		// given
		$batchA = $this->getBatch();

		$batchB = $this->getBatch();
		$batchB->getHeader()->setCompanyEntryDescription('EXPENSES');

		// when
		$this->file->addBatch($batchA);
		$this->file->addBatch($batchB);

		// then
		$this->assertEquals("101 051000033 0599999970602102232A094101ImdDest Name           ImdOriginName          Referenc
5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     1010212340000001
62709101298746479999         0000055000SomePerson1255 Alex Dubrovsky        S 1999363400000001
705Lorem Ipsum                                                                     00010000001
822500000200091012980000000550000000000000001419871234                         010212340000001
5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDEXPENSES  0602  0112     1010212340000002
62709101298746479999         0000055000SomePerson1255 Alex Dubrovsky        S 1999363400000001
705Lorem Ipsum                                                                     00010000001
822500000200091012980000000550000000000000001419871234                         010212340000002
9000002000001000000040018202596000000110000000000000000                                       ", (string)$this->file);
	}

	public function testBatchesAndEntriesNoAddendums() {
		// given
		$batchA = $this->getBatch(false);

		$batchB = $this->getBatch();
		$batchB->getHeader()->setCompanyEntryDescription('EXPENSES');

		// when
		$this->file->addBatch($batchA);
		$this->file->addBatch($batchB);

		// then
		$this->assertEquals("101 051000033 0599999970602102232A094101ImdDest Name           ImdOriginName          Referenc
5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     1010212340000001
62709101298746479999         0000055000SomePerson1255 Alex Dubrovsky        S 0999363400000001
822500000100091012980000000550000000000000001419871234                         010212340000001
5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDEXPENSES  0602  0112     1010212340000002
62709101298746479999         0000055000SomePerson1255 Alex Dubrovsky        S 1999363400000001
705Lorem Ipsum                                                                     00010000001
822500000200091012980000000550000000000000001419871234                         010212340000002
9000002000001000000030018202596000000110000000000000000                                       
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999", (string)$this->file);
	}

	public function testBlockFill() {
		$this->assertEquals("101 051000033 0599999970602102232A094101ImdDest Name           ImdOriginName          Referenc
9000000000001000000000000000000000000000000000000000000                                       
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999", (string)$this->file);
	}

	public function testBatchesAndEntriesWithBlockFill() {
		// given
		$batchA = $this->getBatch();
		$batchA->getHeader()->setCompanyEntryDescription('EXPENSES');
		$batchA->addDebitEntry((new DebitEntry)
			->setTransactionCode(TransactionCode::CHECKING_DEBIT)
			->setReceivingDfiId('09101298')
			->setCheckDigit(7)
			->setDFiAccountNumber('46479999')
			->setAmount('550.00')
			->setIndividualId('SomePerson1255')
			->setIdividualName('Philip Whitt')
			->setDiscretionaryData('S')
			->setAddendaRecordIndicator(0)
			->setTraceNumber('99936340', 2));

		$batchA->addDebitEntry((new DebitEntry)
			->setTransactionCode(TransactionCode::CHECKING_DEBIT)
			->setReceivingDfiId('09101298')
			->setCheckDigit(7)
			->setDFiAccountNumber('46479999')
			->setAmount('550.00')
			->setIndividualId('SomePerson1255')
			->setIdividualName('Philip Whitt')
			->setDiscretionaryData('S')
			->setAddendaRecordIndicator(0)
			->setTraceNumber('99936340', 3));

		// when
		$this->file->addBatch($this->getBatch());
		$this->file->addBatch($batchA);

		// then
		$this->assertEquals("101 051000033 0599999970602102232A094101ImdDest Name           ImdOriginName          Referenc
5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     1010212340000001
62709101298746479999         0000055000SomePerson1255 Alex Dubrovsky        S 1999363400000001
705Lorem Ipsum                                                                     00010000001
822500000200091012980000000550000000000000001419871234                         010212340000001
5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDEXPENSES  0602  0112     1010212340000002
62709101298746479999         0000055000SomePerson1255 Alex Dubrovsky        S 1999363400000001
705Lorem Ipsum                                                                     00010000001
62709101298746479999         0000055000SomePerson1255 Philip Whitt          S 0999363400000002
62709101298746479999         0000055000SomePerson1255 Philip Whitt          S 0999363400000003
822500000400273038940000001650000000000000001419871234                         010212340000002
9000002000002000000060036405192000000220000000000000000                                       
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999", (string)$this->file);
	}

	private function getBatch($addendum = true) {
		$batch = new Batch();
		$batch->getHeader()
			->setCompanyName('MY BEST COMP')
			->setCompanyDiscretionaryData('INCLUDES OVERTIME')
			->setCompanyId('1419871234')
			->setStandardEntryClassCode('PPD')
			->setCompanyEntryDescription('PAYROLL')
			->setCompanyDescriptiveDate('0602')
			->setEffectiveEntryDate('0112')
			->setOriginatorStatusCode('1')
			->setOriginatingDFiId('01021234');

		$entry = (new DebitEntry)
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

		if ($addendum) {
			$entry->addAddenda((new Addenda)
				->setPaymentRelatedInformation('Lorem Ipsum'));
		}

		$batch->addEntry($entry);

		return $batch;
	}

}
