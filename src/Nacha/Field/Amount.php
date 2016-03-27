<?php

namespace Nacha\Field;

class Amount extends Number
{
    public function __construct($value)
    {
        // float value, preserve decimal places
        $value = number_format((float)$value, 2, '.', '');

        // remove dots
        $value = str_replace('.', '', $value);

        if (strlen($value) > 10) {
            throw new InvalidFieldException('Amount "' . $value . '" is too large.');
        }

        parent::__construct($value, 10);
    }
}
