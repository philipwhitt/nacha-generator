<?php

namespace Nacha\Field;

/**
 * Class Number
 * @package Nacha\Field
 */
class Number
{
    /**@var int */
    protected $value;
    /**@var int */
    protected $length;

    public function __construct($value, $length)
    {
        $this->value = (int)$value;
        $this->length = $length;

        if (!is_int($this->value)) {
            throw new InvalidFieldException('Value "' . $value . '" must be an integer.');
        }

        if (strlen($value) > $length) {
            throw new InvalidFieldException('Length of "' . $value . '" must be ' . $length . '.');
        }
    }

    /**
     * @return int
     */
    public function getIntVal()
    {
        return $this->value;
    }

    /**
     * @param int $decimals
     * @return float
     */
    public function getFloatVal($decimals = 2)
    {
        return ($this->value / pow(10, $decimals));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("%0{$this->length}d", $this->value);
    }

}