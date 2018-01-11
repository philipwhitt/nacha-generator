<?php

namespace Nacha\Record;

use Nacha\Field\StringHelper;
use Nacha\Field\Number;

class BatchFooter {

	private $recordTypeCode = 8; // not able to overwrite this 
	private $serviceClassCode;
	private $entryAddendaCount;
	private $entryHash;
	private $totalDebitAmount;
	private $totalCreditAmount;
	private $companyId;
	private $messageAuthenticationCode;
	private $reserved;
	private $originatingDfiId;
	private $batchNumber;

	public function __construct() {
		// defaults/optional
		$this->reserved = new StringHelper('', 6);
		$this->setEntryAddendaCount(0);
		$this->setMessageAuthenticationCode('');
		$this->setTotalDebitAmount(0);
		$this->setTotalCreditAmount(0);
	}

	public function setServiceClassCode($serviceClassCode) {
		$this->serviceClassCode = new Number($serviceClassCode, 3);
		return $this;
	}
	public function setEntryAddendaCount($entryAddendaCount) {
		$this->entryAddendaCount = new Number($entryAddendaCount, 6);
		return $this;
	}
	public function setEntryHash($entryHash) {
		$this->entryHash = new Number($entryHash, 10);
		return $this;
	}
	public function setTotalDebitAmount($totalDebitAmount) {
		$this->totalDebitAmount = new Number($totalDebitAmount, 12);
		return $this;
	}
	public function setTotalCreditAmount($totalCreditAmount) {
		$this->totalCreditAmount = new Number($totalCreditAmount, 12);
		return $this;
	}
	public function setCompanyId($companyId) {
		$this->companyId = new StringHelper($companyId, 10);
		return $this;
	}
	public function setMessageAuthenticationCode($messageAuthenticationCode) {
		$this->messageAuthenticationCode = new StringHelper($messageAuthenticationCode, 19);
		return $this;
	}
	public function setOriginatingDfiId($originatingDfiId) {
		$this->originatingDfiId = new StringHelper($originatingDfiId, 8);
		return $this;
	}
	public function setBatchNumber($batchNumber) {
		$this->batchNumber = new Number($batchNumber, 7);
		return $this;
	}

	public function __toString() {
		return $this->recordTypeCode.
			$this->serviceClassCode.
			$this->entryAddendaCount.
			$this->entryHash.
			$this->totalDebitAmount.
			$this->totalCreditAmount.
			$this->companyId.
			$this->messageAuthenticationCode.
			$this->reserved.
			$this->originatingDfiId.
			$this->batchNumber;
	}

}