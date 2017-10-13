<?php

namespace Nacha\Record;

use Nacha\Field\StringHelper;
use Nacha\Field\Number;

// PPD, TEL, WEB debit
class DebitEntry extends Entry {

	private $checkDigit;
	private $dFiAccountNumber;
	private $individualId;
	private $idividualName;
	private $discretionaryData;

	public function __construct() {
		parent::__construct();

		// defaults
		$this->setIndividualId('');
		$this->setDiscretionaryData('');
	}

	public function getCheckDigit() {
		return $this->checkDigit;
	}
	public function getDFiAccountNumber() {
		return $this->dFiAccountNumber;
	}
	public function getIndividualId() {
		return $this->individualId;
	}
	public function getIdividualName() {
		return $this->idividualName;
	}
	public function getDiscretionaryData() {
		return $this->discretionaryData;
	}

	public function setCheckDigit($checkDigit) {
		$this->checkDigit = new Number($checkDigit, 1);
		return $this;
	}
	public function setDFiAccountNumber($dFiAccountNumber) {
		$this->dFiAccountNumber = new StringHelper($dFiAccountNumber, 17);
		return $this;
	}
	public function setIndividualId($individualId) {
		$this->individualId = new StringHelper($individualId, 15);
		return $this;
	}
	public function setIdividualName($idividualName) {
		$this->idividualName = new StringHelper($idividualName, 22);
		return $this;
	}
	public function setDiscretionaryData($discretionaryData) {
		$this->discretionaryData = new StringHelper($discretionaryData, 2);
		return $this;
	}

	public function __toString() {
		return $this->recordTypeCode.
			$this->transactionCode.
			$this->receivingDfiId.
			$this->checkDigit.
			$this->dFiAccountNumber.
			$this->amount.
			$this->individualId.
			$this->idividualName.
			$this->discretionaryData.
			$this->addendaRecordIndicator.
			$this->traceNumber;
	}

}
