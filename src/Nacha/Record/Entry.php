<?php

namespace Nacha\Record;

use Nacha\Field\String;
use Nacha\Field\Number;
use Nacha\Field\TransactionCode;
use Nacha\Field\Amount;

abstract class Entry {

	protected $recordTypeCode = 6;
	protected $receivingDfiId;
	protected $traceNumber;
	protected $transactionCode;
	protected $amount;

	private $hashable = 0;

	public function __construct() {
		// initialize
		$this->setTransactionCode(TransactionCode::CHECKING_DEPOSIT);
		$this->setAmount(0);
		$this->setTraceNumber(0, 0);
	}

	public function getReceivingDfiId() {
		return $this->receivingDfiId;
	}
	public function getHashable() {
		return $this->hashable;
	}
	public function getAmount() {
		return $this->amount;
	}
	public function getTransactionCode() {
		return $this->transactionCode;
	}
	public final function getTraceNumber() {
		return $this->traceNumber;
	}

	public function setReceivingDFiId($receivingDfiId) {
		$this->setHashable($receivingDfiId);
		$this->receivingDfiId = new Number($receivingDfiId, 8);
		return $this;
	}
	public function setHashable($hashable) {
		$this->hashable = $hashable;
		return $this;
	}
	public function setAmount($amount) {
		$this->amount = new Amount($amount);
		return $this;
	}
	public function setTransactionCode($transactionCode) {
		$this->transactionCode = new TransactionCode($transactionCode);
		return $this;
	}
	public final function setTraceNumber($odfi, $count) {
		$this->traceNumber = (new Number($odfi, 8)) . (new Number($count, 7));
		return $this;
	}

	abstract public function __toString();

}
