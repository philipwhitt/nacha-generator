<?php

namespace Nacha\Field;

class Str
{
    protected $value;
    protected $length;

    public function __construct($value, $length)
    {
        $this->value = substr($value, 0, $length);
        $this->length = $length;

        if (!is_string($value)) {
            throw new InvalidFieldException('Value "' . $value . '" must be an string.');
        }

        if (preg_match('/[^\x20-\x7F]/', $value)) {
            throw new InvalidFieldException('Value "' . $value . '" has invalid ascii characters.');
        }
    }

    public function __toString()
    {
        $str = sprintf('%-' . $this->length . 's', $this->value);
        return strtoupper($str);
    }
}
