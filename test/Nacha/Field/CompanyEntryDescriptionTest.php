<?php

namespace Nacha\Field;

class CompanyEntryDescriptionTest extends \PHPUnit_Framework_TestCase
{

    public function testUpperCaseTriggerWord()
    {
        // given
        $entry = new CompanyEntryDescription('no check found');

        // then
        $this->assertEquals('NO CHECK F', (string)$entry);
    }

    public function testUpperCaseTriggerWord_Negative()
    {
        // given
        $entry = new CompanyEntryDescription('some prod');

        // then
        $this->assertEquals('SOME PROD ', (string)$entry);
    }

}