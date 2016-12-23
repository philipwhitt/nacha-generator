<?php

namespace Nacha\Field;

class CompanyEntryDescription extends Str
{
    // upper case trigger words
    private $triggers = [
        "reversal", "reclaim", "nonsettled", "autoenroll", "redepcheck", "no check", "return fee",
        "hcclaimpmt"
    ];

    public function __construct($value)
    {
        foreach ($this->triggers as $trigger) {
            if (stristr(strtolower($value), $trigger)) {
                $value = strtoupper($value);
            }
        }

        parent::__construct($value, 10);
    }
}
