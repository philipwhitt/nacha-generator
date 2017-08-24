<?php

namespace Nacha;

use Nacha\Field\TransactionCode;
use Nacha\Record\BatchHeader;
use Nacha\Record\BatchFooter;
use Nacha\Record\DebitEntry;
use Nacha\Record\CcdEntry;
use Nacha\Record\Entry;
use Nacha\LineEnding;

/**
 * Class Batch
 * @package Nacha
 */
class Batch {

	// Service Class Codes
	const MIXED        = 200;
	const CREDITS_ONLY = 220;
	const DEBITS_ONLY  = 225;

	/**
	 * @var BatchHeader
	 */
	private $header;

	/**
	 * @var null|string
	 */
	private $lineEnding;

	/**
	 * @var Entry[]
	 */
	private $entries = [];

	private $creditEntryCount = 0;
	private $debitEntryCount = 0;

	public function __construct($lineEnding=null) {
		$this->header = new BatchHeader();
		$this->lineEnding = is_null($lineEnding) ? LineEnding::UNIX : $lineEnding;
	}

	/**
	 * @return BatchHeader
	 */
	public function getHeader() {
		return $this->header;
	}

	/**
	 * @return int
	 */
	public function getTotalEntryCount() {
		return count($this->entries);
	}

	/**
	 * @return int
	 */
	public function getTotalDebitAmount() {
		$amount = 0;
		foreach ($this->entries as $entry) {
			if(!$this->isDebit($entry)) {
				continue;
			}
			$amount += $entry->getAmount()->getValue();
		}
		return $amount;
	}

	/**
	 * @return int
	 */
	public function getTotalCreditAmount() {
		$amount = 0;
		foreach ($this->entries as $entry) {
			if(!$this->isCredit($entry)) {
				continue;
			}
			$amount += $entry->getAmount()->getValue();
		}
		return $amount;
	}

	/**
	 * @param DebitEntry $entry
	 * @return Batch
	 * @deprecated
	 */
	public function addDebitEntry(DebitEntry $entry) {
		return $this->addEntry($entry);
	}

	/**
	 * @param CcdEntry $entry
	 * @return Batch
	 * @deprecated
	 */
	public function addCreditEntry(CcdEntry $entry) {
		return $this->addEntry($entry);
	}

	/**
	 * @param Entry $entry
	 * @return $this
	 */
	public function addEntry(Entry $entry) {
		$this->entries[] = $entry;

		if($this->isCredit($entry)) {
			$this->creditEntryCount++;
		}
		if($this->isDebit($entry)) {
			$this->debitEntryCount++;
		}
		return $this;
	}

	/**
	 * @return int
	 */
	public function getEntryHash() {
		$hash    = 0;

		foreach ($this->entries as $entry) {
			$hash += $entry->getHashable();
		}

		$hashStr = substr((string)$hash, -10); // only take 10 digits from end of string to 10
		return intval($hashStr);
	}

	/**
	 * @param Entry $entry
	 * @return bool
	 */
	private function isCredit(Entry $entry) {
		$creditEntryTransactionCodes = [26,27,28,29,36,37,38,39,46,47,48,49,55,56];
		return in_array($entry->getTransactionCode()->getValue(),$creditEntryTransactionCodes);
	}

	/**
	 * @param Entry $entry
	 * @return bool
	 */
	private function isDebit(Entry $entry) {
		$debitEntryTransactionCodes = [21,22,23,24,31,32,33,34,41,42,43,44,51,52,53,54];
		return in_array($entry->getTransactionCode()->getValue(),$debitEntryTransactionCodes);
	}

	/**
	 * @return bool
	 */
	private function hasOnlyCreditEntries() {
		return ($this->creditEntryCount > 0 && $this->debitEntryCount == 0);
	}

	/**
	 * @return bool
	 */
	private function hasOnlyDebitEntries() {
		return ($this->debitEntryCount > 0 && $this->creditEntryCount == 0);
	}

	private function getServiceClassCode() {
		if($this->hasOnlyCreditEntries()) {
			return self::CREDITS_ONLY;
		}
		if($this->hasOnlyDebitEntries()) {
			return self::DEBITS_ONLY;
		}
		return self::MIXED;
	}

	private function formatEntries() {
		$entries = '';
		foreach($this->entries as $entry) {
			$entries.=(string)$entry.$this->lineEnding;
		}
		return $entries;
	}
	public function __toString() {
		$this->header->setServiceClassCode($this->getServiceClassCode());

		$entries = $this->formatEntries();

		$footer = (new BatchFooter)
			->setEntryAddendaCount($this->getTotalEntryCount())
			->setEntryHash($this->getEntryHash())
			->setCompanyIdNumber((string)$this->header->getCompanyId())
			->setOriginatingDfiId((string)$this->header->getOriginatingDFiId())
			->setBatchNumber((string)$this->getHeader()->getBatchNumber())
			->setTotalDebitAmount($this->getTotalDebitAmount())
			->setTotalCreditAmount($this->getTotalCreditAmount())
			->setServiceClassCode($this->getServiceClassCode());

		return (string)$this->header.$this->lineEnding.$entries.$footer;
	}

}
