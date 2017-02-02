<?php

namespace Nacha\Record;

use Nacha\Field\StringHelper;
use Nacha\Field\Number;

// Cash Collection and Disbursement Entry (CCD)
class CcdEntry extends Entry {

	private $checkDigit;
	private $receivingDFiAccountNumber;
	private $receivingCompanyId;
	private $receivingCompanyName;
	private $discretionaryData;
	private $addendaRecordIndicator;

	public function __construct() {
		parent::__construct();

		// defaults
		$this->setAddendaRecordIndicator(0);
		$this->setReceivingCompanyId('');
		$this->setDiscretionaryData('');
	}

	public function getCheckDigit() {
		return $this->checkDigit;
	}
	public function getReceivingDFiAccountNumber() {
		return $this->receivingDFiAccountNumber;
	}
	public function getReceivingCompanyId() {
		return $this->receivingCompanyId;
	}
	public function getReceivingCompanyName() {
		return $this->receivingCompanyName;
	}
	public function getDiscretionaryData() {
		return $this->discretionaryData;
	}
	public function getAddendaRecordIndicator() {
		return $this->addendaRecordIndicator;
	}

	public function setCheckDigit($checkDigit) {
		$this->checkDigit = new Number($checkDigit, 1);
		return $this;
	}
	public function setReceivingDFiAccountNumber($receivingDFiAccountNumber) {
		$this->receivingDFiAccountNumber = new StringHelper($receivingDFiAccountNumber, 17);
		return $this;
	}
	public function setReceivingCompanyId($receivingCompanyId) {
		$this->receivingCompanyId = new StringHelper($receivingCompanyId, 15);
		return $this;
	}
	public function setReceivingCompanyName($receivingCompanyName) {
		$this->receivingCompanyName = new StringHelper($receivingCompanyName, 22);
		return $this;
	}
	public function setDiscretionaryData($discretionaryData) {
		$this->discretionaryData = new StringHelper($discretionaryData, 2);
		return $this;
	}
	public function setAddendaRecordIndicator($addendaRecordIndicator) {
		$this->addendaRecordIndicator = new Number($addendaRecordIndicator, 1);
		return $this;
	}

	public function __toString() {
		return $this->recordTypeCode.
			$this->transactionCode.
			$this->receivingDfiId.
			$this->checkDigit.
			$this->receivingDFiAccountNumber.
			$this->amount.
			$this->receivingCompanyId.
			$this->receivingCompanyName.
			$this->discretionaryData.
			$this->addendaRecordIndicator.
			$this->traceNumber;
	}

}
