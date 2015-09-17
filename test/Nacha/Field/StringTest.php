<?php

namespace Nacha\Field;

class StringTest extends \PHPUnit_Framework_TestCase {

	public function testPadding() {
		// given
		$str = new String('Hello World', 32);

		// then
		$this->assertEquals('Hello World                     ', (string)$str);
	}

	public function testOptional() {
		// given
		$str = new String('', 10);

		// then
		$this->assertEquals('          ', (string)$str);
	}

	public function testValidCharacters() {
		// given
		$allValidAsciiChars = '';
		
		foreach (range(32, 127) as $ascii) {
			$allValidAsciiChars .= chr($ascii);
		}

		// when
		$str = new String($allValidAsciiChars, strlen($allValidAsciiChars));

		// then
		$this->assertEquals($allValidAsciiChars, (string)$str);
	}

	/**
	 * @expectedException \Nacha\Field\InvalidFieldException
	 */
	public function testNotString() {
		new String(12, 32);
	}

	public function testInvalidCharacter() {
		$asciiValues = array_merge(range(0, 31), range(128, 255));
		foreach ($asciiValues as $ascii) {
			$invalid = 'validtext'.chr($ascii);

			try {
				new String($invalid, strlen($invalid));

				$this->assertTrue(false, 'Should throw an exception for invalid ASCII:'.$ascii);

			} catch (InvalidFieldException $e) {
				$this->assertTrue(true);
			}
		}
	}
}