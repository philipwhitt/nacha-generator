<?php

namespace Nacha\Record;

use Nacha\Field\String;
use Nacha\Field\Number;

// Cash Collection and Disbursement Entry (CCD)
class CcdEntry {

	private $recordTypeCode;
	private $transactionCode;
	private $receivingDfiId;
	private $checkDigit;
	private $receivingDFiAccountNumber;
	private $amount;
	private $receivingCompanyId;
	private $receivingCompanyName;
	private $discretionaryData;
	private $addendaRecordIndicator;
	private $traceNumber;

	public function __construct() {
		// defaults
		$this->setReceivingCompanyId('');
		$this->setDiscretionaryData('');
	}

	public function setRecordTypeCode($recordTypeCode) {
		$this->recordTypeCode = new Number($recordTypeCode, 1);
		return $this;
	}
	public function setTransactionCode($transactionCode) {
		$this->transactionCode = new Number($transactionCode, 2);
		return $this;
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
	public function setTraceNumber($traceNumber) {
		$this->traceNumber = new Number($traceNumber, 15);
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
