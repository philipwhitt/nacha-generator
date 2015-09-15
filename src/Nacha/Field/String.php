<?php

namespace Nacha\Field;

class String
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

        if (!preg_match('/^[\w\s-]*$/', $value)) {
            throw new InvalidFieldException('Value "' . $value . '" has invalid ascii characters.');
        }
    }

    public function __toString()
    {
        return sprintf('%-' . $this->length . 's', $this->value);
    }
}
