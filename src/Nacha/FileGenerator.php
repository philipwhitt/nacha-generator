<?php

namespace Nacha;

use Nacha\Record\FileHeader;
use Nacha\Record\FileFooter;

class FileGenerator {

	private $header;
	private $batches = [];

	public function __construct() {
		$this->header = new FileHeader();
	}

	public function getHeader() {
		return $this->header;
	}
	public function getBatches() {
		return $this->batches;
	}
	public function addBatch(Batch $batch) {
		$this->batches[] = $batch;
		$batch->getHeader()->setBatchNumber(count($this->batches));
	}

	public function __toString() {
		$batches = '';

		$fileFooter = (new FileFooter)
			->setBatchCount(count($this->batches))
			->setBlockCount(1) // @todo wtf is this?
			->setEntryHash(9101298); // @todo calculate this

		$totalDebits     = 0;
		$totalCredits    = 0;
		$totalEntryCount = 0;

		foreach ($this->batches as $batch) {
			$totalEntryCount += $batch->getTotalEntryCount();
			$totalDebits     += $batch->getTotalDebitAmount(); // is this total amount of debits, or entries?
			$totalCredits    += $batch->getTotalCreditAmount(); // is this total amount of credits, or entries?

			$batches .= $batch."\n";
		}

		$fileFooter->setEntryAddendaCount($totalEntryCount);
		$fileFooter->setTotalDebits($totalDebits);
		$fileFooter->setTotalCredits($totalCredits);

		return $this->header."\n".$batches.$fileFooter;
	}

}