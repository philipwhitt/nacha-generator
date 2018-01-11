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
		$total = 0;
		foreach ($this->entries as $entry) {
			$total++;
			$total += count($entry->getAddendas());
		}
		return $total;
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
			if (!$this->isCredit($entry)) {
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

		if ($this->isCredit($entry)) {
			$this->creditEntryCount++;
		}

		if ($this->isDebit($entry)) {
			$this->debitEntryCount++;
		}

		return $this;
	}

	/**
	 * @return int
	 */
	public function getEntryHash() {
		$hash = 0;

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
	private function isDebit(Entry $entry) {
		return TransactionCode::isDebit($entry->getTransactionCode()->getValue());

	}

	/**
	 * @param Entry $entry
	 * @return bool
	 */
	private function isCredit(Entry $entry) {
		return TransactionCode::isCredit($entry->getTransactionCode()->getValue());
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
		$secCode = self::MIXED;

		if ($this->hasOnlyCreditEntries()) {
			$secCode = self::CREDITS_ONLY;
		}

		if ($this->hasOnlyDebitEntries()) {
			$secCode = self::DEBITS_ONLY;
		}

		return $secCode;
	}

	private function formatEntries() {
		$entries = '';

		foreach ($this->entries as $entry) {
			$entries .= (string)$entry.$this->lineEnding;

			if (count($entry->getAddendas()) > 0) {
				$entries .= $this->formatAddendas($entry);
			}
		}

		return $entries;
	}

	private function formatAddendas($entry) {
		$addendas = '';

		foreach ($entry->getAddendas() as $index => $addenda) {
			$addenda->setAddendaSequenceNumber($index+1); // offset for 0 index
			$addenda->setEntryDetailSequenceNumber($entry->getTraceNumber());

			$addendas .= (string)$addenda.$this->lineEnding;
		}

		return $addendas;
	}

	public function __toString() {
		$this->header->setServiceClassCode($this->getServiceClassCode());

		$entries = $this->formatEntries();

		$footer = (new BatchFooter)
			->setEntryAddendaCount($this->getTotalEntryCount())
			->setEntryHash($this->getEntryHash())
			->setCompanyId((string)$this->header->getCompanyId())
			->setOriginatingDfiId((string)$this->header->getOriginatingDFiId())
			->setBatchNumber((string)$this->getHeader()->getBatchNumber())
			->setTotalDebitAmount($this->getTotalDebitAmount())
			->setTotalCreditAmount($this->getTotalCreditAmount())
			->setServiceClassCode($this->getServiceClassCode());

		return (string)$this->header.$this->lineEnding.$entries.$footer;
	}

}
