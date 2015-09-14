<?php

namespace Nacha\Record;

use Nacha\Field\String;
use Nacha\Field\Number;
use Nacha\Field\TransactionCode;

abstract class Entry {

	protected $recordTypeCode = 6;
	protected $traceNumber;
	protected $transactionCode;

	public function getTransactionCode() {
		return $this->transactionCode;
	}
	public final function getTraceNumber() {
		return $this->traceNumber;
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
