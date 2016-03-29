<?php

namespace Nacha;

use Nacha\Record\Entry;

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

	public function testBatchesAndEntries() {
		// given
		$batchA = $this->getBatch();

		$batchB = $this->getBatch();
		$batchB->getHeader()->setCompanyEntryDescription('EXPENSES');

		// when
		$this->file->addBatch($batchA);
		$this->file->addBatch($batchB);
		$test_string = "101 051000033 0599999970602102232A094101IMDDEST NAME           IMDORIGINNAME          REFERENC\n" .
					   "5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n" .
					   "62709101298746479999         0000055000SOMEPERSON1255 ALEX DUBROVSKY        S 0999363400000015\n" .
					   "822500000100091012980000000550000000000000001419871234                         010212340000001\n" .
					   "5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDEXPENSES  0602  0112     2010212340000002\n" .
					   "62709101298746479999         0000055000SOMEPERSON1255 ALEX DUBROVSKY        S 0999363400000015\n" .
					   "822500000100091012980000000550000000000000001419871234                         010212340000002\n" .
					   "9000002000001000000020018202596000000110000000000000000                                       \n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999";

		// then
		$this->assertEquals($test_string, (string)$this->file);
	}

	public function testBlockFill() {
		$test_string = "101 051000033 0599999970602102232A094101IMDDEST NAME           IMDORIGINNAME          REFERENC\n" .
					   "9000000000001000000000000000000000000000000000000000000                                       \n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999";
		$this->assertEquals($test_string, (string)$this->file);
	}

	public function testNoBlockFill() {
		// given
		$batchA = $this->getBatch();
		$batchA->getHeader()->setCompanyEntryDescription('EXPENSES');
		$batchA->addDebitEntry((new Entry)
			->setTransactionCode(27)
			->setReceivingDfiId('09101298')
			->setCheckDigit(7)
			->setDFiAccountNumber('46479999')
			->setAmount('550.00')
			->setSubjectId('SomePerson1255')
			->setSubjectName('Philip Whitt')
			->setDiscretionaryData('S')
			->setAddendaRecordIndicator(0)
			->setTraceNumber('99936340', 15));

		$batchA->addDebitEntry((new Entry)
			->setTransactionCode(27)
			->setReceivingDfiId('09101298')
			->setCheckDigit(7)
			->setDFiAccountNumber('46479999')
			->setAmount('550.00')
			->setSubjectId('SomePerson1255')
			->setSubjectName('Philip Whitt')
			->setDiscretionaryData('S')
			->setAddendaRecordIndicator(0)
			->setTraceNumber('99936340', 15));

		// when
		$this->file->addBatch($this->getBatch());
		$this->file->addBatch($batchA);
		$test_string = "101 051000033 0599999970602102232A094101IMDDEST NAME           IMDORIGINNAME          REFERENC\n" .
					   "5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n" .
					   "62709101298746479999         0000055000SOMEPERSON1255 ALEX DUBROVSKY        S 0999363400000015\n" .
					   "822500000100091012980000000550000000000000001419871234                         010212340000001\n" .
					   "5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDEXPENSES  0602  0112     2010212340000002\n" .
					   "62709101298746479999         0000055000SOMEPERSON1255 ALEX DUBROVSKY        S 0999363400000015\n" .
					   "62709101298746479999         0000055000SOMEPERSON1255 PHILIP WHITT          S 0999363400000015\n" .
					   "62709101298746479999         0000055000SOMEPERSON1255 PHILIP WHITT          S 0999363400000015\n" .
					   "822500000300273038940000001650000000000000001419871234                         010212340000002\n" .
					   "9000002000001000000040036405192000000220000000000000000                                       ";
		
		// then
		$this->assertEquals($test_string, (string)$this->file);
	}

	public function testBlockWithEntries() {
		// given
		$batchA = $this->getBatch();
		$batchA->getHeader()->setCompanyEntryDescription('EXPENSES');
		$batchA->addDebitEntry((new Entry)
			->setTransactionCode(27)
			->setReceivingDfiId('09101298')
			->setCheckDigit(7)
			->setDFiAccountNumber('46479999')
			->setAmount('550.00')
			->setSubjectId('SomePerson1255')
			->setSubjectName('Philip Whitt')
			->setDiscretionaryData('S')
			->setAddendaRecordIndicator(0)
			->setTraceNumber('99936340', 15));

		// when
		$this->file->addBatch($this->getBatch());
		$this->file->addBatch($this->getBatch());
		$this->file->addBatch($batchA);
		$test_string = "101 051000033 0599999970602102232A094101IMDDEST NAME           IMDORIGINNAME          REFERENC\n" .
					   "5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n" .
					   "62709101298746479999         0000055000SOMEPERSON1255 ALEX DUBROVSKY        S 0999363400000015\n" .
					   "822500000100091012980000000550000000000000001419871234                         010212340000001\n" .
					   "5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000002\n" .
					   "62709101298746479999         0000055000SOMEPERSON1255 ALEX DUBROVSKY        S 0999363400000015\n" .
					   "822500000100091012980000000550000000000000001419871234                         010212340000002\n" .
					   "5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDEXPENSES  0602  0112     2010212340000003\n" .
					   "62709101298746479999         0000055000SOMEPERSON1255 ALEX DUBROVSKY        S 0999363400000015\n" .
					   "62709101298746479999         0000055000SOMEPERSON1255 PHILIP WHITT          S 0999363400000015\n" .
					   "822500000200182025960000001100000000000000001419871234                         010212340000003\n" .
					   "9000003000002000000040036405192000000220000000000000000                                       \n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999\n" .
					   "9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999";

		// then
		$this->assertEquals($test_string, (string)$this->file);
	}

	private function getBatch() {
		$batch = new Batch();
		$batch->getHeader()
			->setCompanyName('MY BEST COMP')
			->setCompanyDiscretionaryData('INCLUDES OVERTIME')
			->setCompanyId('1419871234')
			->setStandardEntryClassCode('PPD')
			->setCompanyEntryDescription('PAYROLL')
			->setCompanyDescriptiveDate('0602')
			->setEffectiveEntryDate('0112')
			->setOriginatorStatusCode('2')
			->setOriginatingDFiId('01021234');

		$batch->addDebitEntry((new Entry)
			->setTransactionCode(27)
			->setReceivingDfiId('09101298')
			->setCheckDigit(7)
			->setDFiAccountNumber('46479999')
			->setAmount('550.00')
			->setSubjectId('SomePerson1255')
			->setSubjectName('Alex Dubrovsky')
			->setDiscretionaryData('S')
			->setAddendaRecordIndicator(0)
			->setTraceNumber('99936340', 15));

		return $batch;
	}

}
