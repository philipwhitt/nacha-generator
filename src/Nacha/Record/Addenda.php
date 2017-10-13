<?php

namespace Nacha\Record;

use Nacha\Field\AddendaType;
use Nacha\Field\StringHelper;
use Nacha\Field\Number;

class Addenda {

	private $recordTypeCode = 7; // not able to overwrite this 
	private $addendaTypeCode;
	private $paymentRelatedInformation;
	private $addendaSequenceNumber;
	private $entryDetailSequenceNumber;

	public function __construct() {
		// set defaults
		$this->setAddendaTypeCode(AddendaType::ADDENDA);
	}

	public function getAddendaTypeCode() {
		return $this->addendaTypeCode;
	}
	public function getPaymentRelatedInformation() {
		return $this->paymentRelatedInformation;
	}
	public function getAddendaSequenceNumber() {
		return $this->addendaSequenceNumber;
	}
	public function getEntryDetailSequenceNumber() {
		return $this->entryDetailSequenceNumber;
	}

	public function setAddendaTypeCode($addendaTypeCode) {
		$this->addendaTypeCode = new AddendaType($addendaTypeCode);
		return $this;
	}
	public function setPaymentRelatedInformation($paymentRelatedInformation) {
		$this->paymentRelatedInformation = new StringHelper($paymentRelatedInformation, 80);
		return $this;
	}
	public function setAddendaSequenceNumber($addendaSequenceNumber) {
		$this->addendaSequenceNumber = new Number($addendaSequenceNumber, 4);
		return $this;
	}
	public function setEntryDetailSequenceNumber($entryDetailSequenceNumber) {
		// only take last 7 digits from what should be the entry trace number (field 13)
		$lastSeven = substr((string)$entryDetailSequenceNumber, -7);

		$this->entryDetailSequenceNumber = new Number($lastSeven, 7);
		return $this;
	}

	public function __toString() {
		return $this->recordTypeCode.
			$this->addendaTypeCode.
			$this->paymentRelatedInformation.
			$this->addendaSequenceNumber.
			$this->entryDetailSequenceNumber;
	}

}

