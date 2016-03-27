<?php

namespace Nacha\Field;

class StandardEntryClassTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Nacha\Field\InvalidFieldException
     */
    public function testInvalidType()
    {
        new StandardEntryClass('asd');
    }

    public function testValid()
    {
        // given
        $sec = new StandardEntryClass('ppd');

        // then
        $this->assertEquals('PPD', (string)$sec);
    }

}