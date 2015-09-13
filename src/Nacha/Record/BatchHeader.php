<?php

namespace Nacha\Record;

use Nacha\Field\String;
use Nacha\Field\Number;
use Nacha\Field\CompanyName;
use Nacha\Field\StandardEntryClass;
use Nacha\Field\CompanyEntryDescription;

class BatchHeader {

	private $recordTypeCode = 5; // not able to overwrite this 
	private $serviceClassCode;
	private $companyName;
	private $companyDiscretionaryData;
	private $companyId;
	private $standardEntryClassCode;
	private $companyEntryDescription;
	private $companyDescriptiveDate;
	private $effectiveEntryDate;
	private $settlementDate;
	private $originatorStatusCode;
	private $originatingDFiId;
	private $batchNumber;

	public function __construct() {
		// defaults
		$this->setEffectiveEntryDate(date('ymd', time()));

		// Set by operator
		$this->setSettlementDate('');

		// optional fields
		$this->setCompanyDiscretionaryData('');
		$this->setCompanyDescriptiveDate('');
	}

	public function getServiceClassCode() {
		return $this->serviceClassCode;
	}
	public function getCompanyName() {
		return $this->companyName;
	}
	public function getCompanyDiscretionaryData() {
		return $this->companyDiscretionaryData;
	}
	public function getCompanyId() {
		return $this->companyId;
	}
	public function getStandardEntryClassCode() {
		return $this->standardEntryClassCode;
	}
	public function getCompanyEntryDescription() {
		return $this->companyEntryDescription;
	}
	public function getCompanyDescriptiveDate() {
		return $this->companyDescriptiveDate;
	}
	public function getEffectiveEntryDate() {
		return $this->effectiveEntryDate;
	}
	public function getSettlementDate() {
		return $this->settlementDate;
	}
	public function getOriginatorStatusCode() {
		return $this->originatorStatusCode;
	}
	public function getOriginatingDFiId() {
		return $this->originatingDFiId;
	}
	public function getBatchNumber() {
		return $this->batchNumber;
	}

	public function setServiceClassCode($serviceClassCode) {
		$this->serviceClassCode = new Number($serviceClassCode, 3);
		return $this;
	}
	public function setCompanyName($companyName) {
		$this->companyName = new CompanyName($companyName);
		return $this;
	}
	public function setCompanyDiscretionaryData($companyDiscretionaryData) {
		$this->companyDiscretionaryData = new String($companyDiscretionaryData, 20);
		return $this;
	}
	public function setCompanyId($companyId) {
		$this->companyId = new String($companyId, 10);
		return $this;
	}
	public function setStandardEntryClassCode($standardEntryClassCode) {
		$this->standardEntryClassCode = new StandardEntryClass($standardEntryClassCode);
		return $this;
	}
	public function setCompanyEntryDescription($companyEntryDescription) {
		$this->companyEntryDescription = new CompanyEntryDescription($companyEntryDescription);
		return $this;
	}
	public function setCompanyDescriptiveDate($companyDescriptiveDate) {
		$this->companyDescriptiveDate = new String($companyDescriptiveDate, 6);
		return $this;
	}
	public function setEffectiveEntryDate($effectiveEntryDate) {
		$this->effectiveEntryDate = new String($effectiveEntryDate, 6);
		return $this;
	}
	public function setSettlementDate($settlementDate) {
		$this->settlementDate = new String($settlementDate, 3);
		return $this;
	}
	public function setOriginatorStatusCode($originatorStatusCode) {
		$this->originatorStatusCode = new String($originatorStatusCode, 1);
		return $this;
	}
	public function setOriginatingDFiId($originatingDFiId) {
		$this->originatingDFiId = new String($originatingDFiId, 8);
		return $this;
	}
	public function setBatchNumber($batchNumber) {
		$this->batchNumber = new Number($batchNumber, 7);
		return $this;
	}

	public function __toString() {
		return $this->recordTypeCode.
			$this->serviceClassCode.
			$this->companyName.
			$this->companyDiscretionaryData.
			$this->companyId.
			$this->standardEntryClassCode.
			$this->companyEntryDescription.
			$this->companyDescriptiveDate.
			$this->effectiveEntryDate.
			$this->settlementDate.
			$this->originatorStatusCode.
			$this->originatingDFiId.
			$this->batchNumber;
	}

}