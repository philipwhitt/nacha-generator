<?php

namespace Nacha\Field;

class StringTest extends \PHPUnit_Framework_TestCase {

	public function testPadding() {
		// given
		$str = new String('Hello World', 32);

		// then
		$this->assertEquals('Hello World                     ', (string)$str);
	}

}