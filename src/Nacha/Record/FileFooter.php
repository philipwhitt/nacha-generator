<?php

namespace Nacha\Record;

use Nacha\Field\Str;
use Nacha\Field\Number;

/**
 * Class FileFooter
 * @package Nacha\Record
 */
class FileFooter
{
    private $recordTypeCode = 9; // not able to overwrite this
    /**@var \Nacha\Field\Number */
    private $batchCount;
    /**@var \Nacha\Field\Number */
    private $blockCount;
    /**@var \Nacha\Field\Number */
    private $entryAddendaCount;
    /**@var \Nacha\Field\Number */
    private $entryHash;
    /**@var \Nacha\Field\Number */
    private $totalDebits;
    /**@var \Nacha\Field\Number */
    private $totalCredits;
    /**@var \Nacha\Field\Str */
    private $reserved;

    public function __construct()
    {
        // defaults
        $this->reserved = new Str('', 39);
        $this->setBatchCount(0);
        $this->setBlockCount(0);
        $this->setEntryAddendaCount(0);
        $this->setTotalDebits(0);
        $this->setTotalCredits(0);
    }

    /**
     * @param $batchCount
     * @return $this
     */
    public function setBatchCount($batchCount)
    {
        $this->batchCount = new Number($batchCount, 6);
        return $this;
    }

    /**
     * @param $blockCount
     * @return $this
     */
    public function setBlockCount($blockCount)
    {
        $this->blockCount = new Number($blockCount, 6);
        return $this;
    }

    /**
     * @param $entryAddendaCount
     * @return $this
     */
    public function setEntryAddendaCount($entryAddendaCount)
    {
        $this->entryAddendaCount = new Number($entryAddendaCount, 8);
        return $this;
    }

    /**
     * @param $entryHash
     * @return $this
     */
    public function setEntryHash($entryHash)
    {
        $this->entryHash = new Number($entryHash, 10);
        return $this;
    }

    /**
     * @param $totalDebits
     * @return $this
     */
    public function setTotalDebits($totalDebits)
    {
        $this->totalDebits = new Number($totalDebits, 12);
        return $this;
    }

    /**
     * @param $totalCredits
     * @return $this
     */
    public function setTotalCredits($totalCredits)
    {
        $this->totalCredits = new Number($totalCredits, 12);
        return $this;
    }

    /**
     * @return int
     */
    public function getEntryAddendaCount()
    {
        return $this->entryAddendaCount->getIntVal();
    }

    /**
     * @return float
     */
    public function getTotalDebit()
    {
        return $this->totalDebits->getFloatVal();
    }

    /**
     * @return float
     */
    public function getTotalCredit()
    {
        return $this->totalCredits->getFloatVal();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->recordTypeCode .
        $this->batchCount .
        $this->blockCount .
        $this->entryAddendaCount .
        $this->entryHash .
        $this->totalDebits .
        $this->totalCredits .
        $this->reserved;
    }

}