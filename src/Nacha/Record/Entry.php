<?php

namespace Nacha\Record;

use Nacha\Field\String;
use Nacha\Field\Number;
use Nacha\Field\TransactionCode;
use Nacha\Field\Amount;

abstract class Entry {

	protected $recordTypeCode = 6;
	protected $traceNumber;
	protected $transactionCode;
	protected $amount;

	public function __construct() {
		// initialize
		$this->setTransactionCode(TransactionCode::CHECKING_DEPOSIT);
		$this->setAmount(0);
		$this->setTraceNumber(0, 0);
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
