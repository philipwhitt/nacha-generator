<?php

namespace Nacha\Field;

class OriginatorStatusCodeTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException Nacha\Field\InvalidFieldException
	 */
	public function testInvalidType() {
		new OriginatorStatusCode(3);
	}

	public function testValid() {
		// given
		$sec = new OriginatorStatusCode(OriginatorStatusCode::ORIGINATOR_IS_EXEMPT);

		// then
		$this->assertEquals(OriginatorStatusCode::ORIGINATOR_IS_EXEMPT, (string)$sec);
	}

}