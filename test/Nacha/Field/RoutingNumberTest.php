<?php

namespace Nacha\Field;

class RoutingNumberTest extends \PHPUnit_Framework_TestCase
{

    public function testLength()
    {
        // given
        $nbr = new RoutingNumber('001243123');

        // then
        $this->assertEquals('001243123', (string)$nbr);
    }

    /**
     * @expectedException \Nacha\Field\InvalidFieldException
     */
    public function testInvalidLength()
    {
        new RoutingNumber(111101);
    }

}