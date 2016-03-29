<?php

namespace Nacha;

use Nacha\Record\Entry;

/**
 * Class BatchTest
 * @package Nacha
 */
class BatchTest extends \PHPUnit_Framework_TestCase
{

    /** @var Batch */
    private $batch;

    public function setup()
    {
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
    }

    public function testDebitOnlyBatch()
    {
        // when
        $this->batch->addDebitEntry((new Entry)
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

        // then
        $output = (string)$this->batch;

        $this->assertEquals((string)$this->batch->getHeader()->getServiceClassCode(), Batch::DEBITS_ONLY);
        $this->assertEquals(
            "5225MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n" .
            "62709101298746479999         0000055000SOMEPERSON1255 ALEX DUBROVSKY        S 0999363400000015\n" .
            "822500000100091012980000000550000000000000001419871234                         010212340000001",
            $output
        );
    }

    public function testCreditOnlyBatch()
    {
        // when
        $this->batch->addCreditEntry((new Entry)
            ->setTransactionCode(27)
            ->setReceivingDfiId('09101298')
            ->setCheckDigit(7)
            ->setDFiAccountNumber('46479999')
            ->setAmount('600.00')
            ->setSubjectId('Location 23')
            ->setSubjectName('Best Co 23')
            ->setDiscretionaryData('S')
            ->setAddendaRecordIndicator(0)
            ->setTraceNumber('09936340', 15));

        // then
        $output = (string)$this->batch;

        $this->assertEquals((string)$this->batch->getHeader()->getServiceClassCode(), Batch::CREDITS_ONLY);
        $this->assertEquals(
            "5220MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n" .
            "62709101298746479999         0000060000LOCATION 23    BEST CO 23            S 0099363400000015\n" .
            "822000000100091012980000000000000000000600001419871234                         010212340000001",
            $output
        );
    }

    public function testMixedBatch()
    {
        // when
        $this->batch->addCreditEntry((new Entry)
            ->setTransactionCode(27)
            ->setReceivingDfiId('09101298')
            ->setCheckDigit(7)
            ->setDFiAccountNumber('46479999')
            ->setAmount('600.00')
            ->setSubjectId('Location 23')
            ->setSubjectName('Best Co 23')
            ->setDiscretionaryData('S')
            ->setAddendaRecordIndicator(0)
            ->setTraceNumber('09936340', 15));

        $this->batch->addDebitEntry((new Entry)
            ->setTransactionCode(27)
            ->setReceivingDfiId('09101298')
            ->setCheckDigit(7)
            ->setDFiAccountNumber('46479999')
            ->setAmount('550.00')
            ->setSubjectId('SomePerson1255')
            ->setSubjectName('Alex Dubrovsky')
            ->setDiscretionaryData('S')
            ->setAddendaRecordIndicator(0)
            ->setTraceNumber('09936340', 15));

        // then
        $output = (string)$this->batch;

        $this->assertEquals((string)$this->batch->getHeader()->getServiceClassCode(), Batch::MIXED);
        $this->assertEquals(
            "5200MY BEST COMP    INCLUDES OVERTIME   1419871234PPDPAYROLL   0602  0112     2010212340000001\n" .
            "62709101298746479999         0000055000SOMEPERSON1255 ALEX DUBROVSKY        S 0099363400000015\n" .
            "62709101298746479999         0000060000LOCATION 23    BEST CO 23            S 0099363400000015\n" .
            "820000000200182025960000000550000000000600001419871234                         010212340000001",
            $output
        );
    }

}