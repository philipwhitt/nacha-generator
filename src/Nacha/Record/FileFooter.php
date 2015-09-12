<?php

namespace Nacha\Record;

use Nacha\Field\String;
use Nacha\Field\Number;

class FileFooter {

	private $recordTypeCode = 9; // not able to overwrite this 
	private $batchCount;
	private $blockCount;
	private $entryAddendaCount;
	private $entryHash;
	private $totalDebits;
	private $totalCredits;
	private $reserved;

	public function __construct() {
		// defaults
		$this->reserved = new String('', 39);
		$this->setBatchCount(0);
		$this->setBlockCount(0);
		$this->setEntryAddendaCount(0);
		$this->setTotalDebits(0);
		$this->setTotalCredits(0);
	}

	public function setBatchCount($batchCount) {
		$this->batchCount = new Number($batchCount, 6);
		return $this;
	}
	public function setBlockCount($blockCount) {
		$this->blockCount = new Number($blockCount, 6);
		return $this;
	}
	public function setEntryAddendaCount($entryAddendaCount) {
		$this->entryAddendaCount = new Number($entryAddendaCount, 8);
		return $this;
	}
	public function setEntryHash($entryHash) {
		$this->entryHash = new Number($entryHash, 10);
		return $this;
	}
	public function setTotalDebits($totalDebits) {
		$this->totalDebits = new Number($totalDebits, 12);
		return $this;
	}
	public function setTotalCredits($totalCredits) {
		$this->totalCredits = new Number($totalCredits, 12);
		return $this;
	}

	public function __toString() {
		return $this->recordTypeCode.
			$this->batchCount.
			$this->blockCount.
			$this->entryAddendaCount.
			$this->entryHash.
			$this->totalDebits.
			$this->totalCredits.
			$this->reserved;
	}

}