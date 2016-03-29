<?php

namespace Nacha\Field;

class TransactionCode extends Number
{

    const CHECKING_DEPOSIT = 22; // Deposit destined for a Checking Account
    const CHECKING_CREDIT_PRENOTIFICATION = 23; // Prenotification for a checking credit
    const CHECKING_ZERO_DOLLAR = 24; // Zero dollar with remittance into Checking

    const CHECKING_DEBIT = 27; // Debit destined for a Checking Account
    const CHECKING_DEBIT_PRENOTIFICATION = 28; // Prenotification for a checking debit
    const CHECKING_DEBIT_ZERO_DOLLAR = 29; // Zero dollar with remittance into Checking - duplicate?

    const SAVINGS_DEPOSIT = 32; // Deposit destined for a Savings Account
    const SAVINGS_CREDIT_PRENOTIFICATION = 33; // Prenotification for a savings credit
    const SAVINGS_CREDIT_ZERO_DOLLAR = 34; // Zero dollar with remittance into Savings

    const SAVINGS_DEBIT = 37; // Debit destined for a Savings Account
    const SAVINGS_DEBIT_PRENOTIFICATION = 38; // Prenotification for a Savings debit
    const SAVINGS_DEBIT_ZERO_DOLLAR = 39; // Zero dollar with remittance into Savings

    public function __construct($value)
    {
        parent::__construct($value, 2);

        $valid = [
            self::CHECKING_DEPOSIT,
            self::CHECKING_CREDIT_PRENOTIFICATION,
            self::CHECKING_ZERO_DOLLAR,
            self::CHECKING_DEBIT,
            self::CHECKING_DEBIT_PRENOTIFICATION,
            self::CHECKING_DEBIT_ZERO_DOLLAR,
            self::SAVINGS_DEPOSIT,
            self::SAVINGS_CREDIT_PRENOTIFICATION,
            self::SAVINGS_CREDIT_ZERO_DOLLAR,
            self::SAVINGS_DEBIT,
            self::SAVINGS_DEBIT_PRENOTIFICATION,
            self::SAVINGS_DEBIT_ZERO_DOLLAR,
        ];

        if (!in_array($value, $valid)) {
            throw new InvalidFieldException('Invalid transaction code "' . $value . '".');
        }
    }
}
