<?php

namespace Nacha\Field;

class StringTest extends \PHPUnit_Framework_TestCase
{

    public function testPadding()
    {
        // given
        $str = new String('Hello World', 32);

        // then
        $this->assertEquals('HELLO WORLD                     ', (string)$str);
    }

    /**
     * @expectedException \Nacha\Field\InvalidFieldException
     */
    public function testNotString()
    {
        new String(12, 32);
    }

    /**
     * @expectedException \Nacha\Field\InvalidFieldException
     */
    public function testInvalidCharacter()
    {
        new String("!testtext", 32);
    }
}