<?php

namespace Nacha\Field;

class CompanyNameTest extends \PHPUnit_Framework_TestCase {

	public function testUpperCaseTriggerWord() {
		// given
		$entry = new CompanyName('check destroyed');

		// then
		$this->assertEquals('CHECK DESTROYED ', (string)$entry);
	}

	public function stestUpperCaseTriggerWord_Negative() {
		// given
		$entry = new CompanyEntryDescription('check available');

		// then
		$this->assertEquals('check available', (string)$entry);
	}

}