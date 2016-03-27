<?php

namespace Nacha;

use Nacha\Record\Block;
use Nacha\Record\FileHeader;
use Nacha\Record\FileFooter;

/**
 * Class File
 * @package Nacha
 */
class File {

	private $header;
	/** @var Batch[] */
	private $batches = [];

	public function __construct() {
		$this->header = new FileHeader();
	}

    /**
     * @return FileHeader
     */
	public function getHeader() {
		return $this->header;
	}

    /**
     * @return Batch[]
     */
	public function getBatches() {
		return $this->batches;
	}

    /**
     * @param Batch $batch
     */
	public function addBatch(Batch $batch) {
		$this->batches[] = $batch;
		$batch->getHeader()->setBatchNumber(count($this->batches));
	}

    /**
     * @return mixed
     */
	public function getFooter()
	{
        return $this->generateFooter();
	}

    /**
     * @return FileFooter
     */
    private function generateFooter()
    {
        $fileFooter = new FileFooter();
        $totalDebits     = 0;
        $totalCredits    = 0;
        $totalEntryCount = 0;

        foreach ($this->batches as $batch) {
            $totalEntryCount += $batch->getTotalEntryCount();
            $totalDebits     += $batch->getTotalDebitAmount(); // is this total amount of debits, or entries?
            $totalCredits    += $batch->getTotalCreditAmount(); // is this total amount of credits, or entries?
        }

        $totalRecords = $totalEntryCount + (count($this->batches) * 2) + 2;

        $fileFooter->setEntryHash($this->getHash());
        $fileFooter->setBatchCount(count($this->batches));
        $fileFooter->setBlockCount(ceil($totalRecords / 10));
        $fileFooter->setEntryAddendaCount($totalEntryCount);
        $fileFooter->setTotalDebits($totalDebits);
        $fileFooter->setTotalCredits($totalCredits);

        return $fileFooter;
    }

    /**
     * @return string
     */
	private function getHash() {
		$hash = 0;
		foreach ($this->batches as $batch) {
			$hash += $batch->getEntryHash();
		}
		return substr((string)$hash, -10); // only take 10 digits from end of string to 10
	}

    /**
     * @return string
     */
	public function __toString() {
		/**
		 * @var FileFooter $fileFooter
		 */
		$batches = '';
        $fileFooter = $this->getFooter();

		foreach ($this->batches as $batch) {
			$batches .= $batch."\n";
		}

		$totalRecords = $fileFooter->getEntryAddendaCount() + (count($this->batches) * 2) + 2;

		// block padding
		// num entries + num batches header/footer + file header/footer
		$blocksNeeded = (ceil($totalRecords / 10) * 10) - $totalRecords;

		$block = '';
		for ($x=0; $x<$blocksNeeded % 10; $x++) {
			$block .= (new Block)."\n";
		}

		$output = $this->header."\n".$batches.$fileFooter."\n".$block;

		return rtrim($output, "\n");
	}

}