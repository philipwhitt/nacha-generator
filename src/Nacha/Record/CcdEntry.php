<?php

namespace Nacha\Record;

use Nacha\Field\String;
use Nacha\Field\Number;

// Cash Collection and Disbursement Entry (CCD)
class CcdEntry extends Entry {

	private $receivingDfiId;
	private $checkDigit;
	private $receivingDFiAccountNumber;
	private $amount;
	private $receivingCompanyId;
	private $receivingCompanyName;
	private $discretionaryData;
	private $addendaRecordIndicator;

	public function __construct() {
		// defaults
		$this->setAddendaRecordIndicator(0);
		$this->setReceivingCompanyId('');
		$this->setDiscretionaryData('');
	}

	public function getReceivingDfiId() {
		return $this->receivingDfiId;
	}
	public function getCheckDigit() {
		return $this->checkDigit;
	}
	public function getReceivingDFiAccountNumber() {
		return $this->receivingDFiAccountNumber;
	}
	public function getAmount() {
		return $this->amount;
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

	public function setReceivingDFiId($receivingDfiId) {
		$this->receivingDfiId = new Number($receivingDfiId, 8);
		return $this;
	}
	public function setCheckDigit($checkDigit) {
		$this->checkDigit = new Number($checkDigit, 1);
		return $this;
	}
	public function setReceivingDFiAccountNumber($receivingDFiAccountNumber) {
		$this->receivingDFiAccountNumber = new String($receivingDFiAccountNumber, 17);
		return $this;
	}
	public function setAmount($amount) {
		$this->amount = new Number($amount, 10);
		return $this;
	}
	public function setReceivingCompanyId($receivingCompanyId) {
		$this->receivingCompanyId = new String($receivingCompanyId, 15);
		return $this;
	}
	public function setReceivingCompanyName($receivingCompanyName) {
		$this->receivingCompanyName = new String($receivingCompanyName, 22);
		return $this;
	}
	public function setDiscretionaryData($discretionaryData) {
		$this->discretionaryData = new String($discretionaryData, 2);
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
