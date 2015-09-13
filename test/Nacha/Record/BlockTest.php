<?php

namespace Nacha\Record;

class BlockTest extends \PHPUnit_Framework_TestCase {

	public function testBatchHeader_AllFields() {
		// given
		$block = new Block;

		// then
		$this->assertEquals(94, strlen((string)$block));
	}

}