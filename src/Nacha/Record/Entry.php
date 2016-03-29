<?php

namespace Nacha\Record;

use Nacha\Field\Amount;
use Nacha\Field\Number;
use Nacha\Field\String;
use Nacha\Field\TransactionCode;

class Entry
{
    protected $recordTypeCode = 6;
    protected $receivingDfiId;
    protected $traceNumber;
    protected $transactionCode;
    protected $amount;
    protected $checkDigit;
    protected $dFiAccountNumber;
    protected $subjectId;
    protected $subjectName;
    protected $discretionaryData;
    protected $addendaRecordIndicator;

    private $hashable = 0;

    public function __construct()
    {
        // initialize
        $this->setTransactionCode(TransactionCode::CHECKING_DEPOSIT);
        $this->setAmount(0);
        $this->setTraceNumber(0, 0);

        // defaults
        $this->setSubjectId('');
        $this->setDiscretionaryData('');
        $this->setAddendaRecordIndicator(0);
    }

    public function getCheckDigit()
    {
        return $this->checkDigit;
    }

    public function getReceivingDfiId()
    {
        return $this->receivingDfiId;
    }

    public function getDFiAccountNumber()
    {
        return $this->dFiAccountNumber;
    }

    public function getSubjectId()
    {
        return $this->subjectId;
    }

    public function getSubjectName()
    {
        return $this->subjectName;
    }

    public function getDiscretionaryData()
    {
        return $this->discretionaryData;
    }

    public function getAddendaRecordIndicator()
    {
        return $this->addendaRecordIndicator;
    }

    public function getHashable()
    {
        return $this->hashable;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getTransactionCode()
    {
        return $this->transactionCode;
    }

    final public function getTraceNumber()
    {
        return $this->traceNumber;
    }

    public function setCheckDigit($checkDigit)
    {
        $this->checkDigit = new Number($checkDigit, 1);
        return $this;
    }

    public function setReceivingDFiId($receivingDfiId)
    {
        $this->setHashable($receivingDfiId);
        $this->receivingDfiId = new Number($receivingDfiId, 8);
        return $this;
    }

    public function setDFiAccountNumber($dFiAccountNumber)
    {
        $this->dFiAccountNumber = new String($dFiAccountNumber, 17);
        return $this;
    }

     public function setSubjectId($subjectId)
    {
        $this->subjectId = new String($subjectId, 15);
        return $this;
    }

    public function setSubjectName($subjectName)
    {
        $this->subjectName = new String($subjectName, 22);
        return $this;
    }

    public function setDiscretionaryData($discretionaryData)
    {
        $this->discretionaryData = new String($discretionaryData, 2);
        return $this;
    }

    public function setAddendaRecordIndicator($addendaRecordIndicator)
    {
        $this->addendaRecordIndicator = new Number($addendaRecordIndicator, 1);
        return $this;
    }

    public function setHashable($hashable)
    {
        $this->hashable = $hashable;
        return $this;
    }

    public function setAmount($amount)
    {
        $this->amount = new Amount($amount);
        return $this;
    }

    public function setTransactionCode($transactionCode)
    {
        $this->transactionCode = new TransactionCode($transactionCode);
        return $this;
    }

    final public function setTraceNumber($odfi, $count)
    {
        $this->traceNumber = (new Number($odfi, 8)) . (new Number($count, 7));
        return $this;
    }

    public function __toString()
    {
        return $this->recordTypeCode .
        $this->transactionCode .
        $this->receivingDfiId .
        $this->checkDigit .
        $this->dFiAccountNumber .
        $this->amount .
        $this->subjectId .
        $this->subjectName .
        $this->discretionaryData .
        $this->addendaRecordIndicator .
        $this->traceNumber;
    }
}
