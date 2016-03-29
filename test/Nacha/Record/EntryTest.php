<?php

namespace Nacha\Record;

class EntryTest extends \PHPUnit_Framework_TestCase
{

    public function testEntry_AllFields()
    {
        // given
        $entry = (new Entry)
            ->setTransactionCode(27)
            ->setReceivingDfiId('09101298')
            ->setCheckDigit(7)
            ->setDFiAccountNumber('46479999')
            ->setAmount('550.00')
            ->setSubjectId('SomePerson1255')
            ->setSubjectName('Alex Dubrovsky')
            ->setDiscretionaryData('S')
            ->setAddendaRecordIndicator(0)
            ->setTraceNumber('09101298', 15);

        $this->assertEquals(94, strlen($entry));
        $this->assertEquals('62709101298746479999         0000055000SOMEPERSON1255 ALEX DUBROVSKY        S 0091012980000015', (string)$entry);
    }

    public function testEntry_OptionalFields()
    {
        // given
        $entry = (new Entry)
            ->setTransactionCode(27)
            ->setReceivingDfiId('09101298')
            ->setCheckDigit(7)
            ->setDFiAccountNumber('46479999')
            ->setAmount('550.00')
            ->setSubjectName('Alex Dubrovsky')
            ->setAddendaRecordIndicator(0)
            ->setTraceNumber('09101298', 15);

        $this->assertEquals(94, strlen($entry));
        $this->assertEquals('62709101298746479999         0000055000               ALEX DUBROVSKY          0091012980000015', (string)$entry);
    }

}