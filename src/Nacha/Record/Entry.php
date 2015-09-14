<?php

namespace Nacha\Record;

use Nacha\Field\String;
use Nacha\Field\Number;

abstract class Entry {

	protected $recordTypeCode = 6;
	protected $traceNumber;

	public final function getTraceNumber() {
		return $this->traceNumber;
	}

	public final function setTraceNumber($odfi, $count) {
		$this->traceNumber = (new Number($odfi, 8)) . (new Number($count, 7));
		return $this;
	}

	abstract public function __toString();

}
