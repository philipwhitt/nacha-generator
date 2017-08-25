<?php

namespace Nacha\Field;

class TransactionCode extends Number {

	const CHECKING_CREDIT_RETURN       	  = 21;
	const CHECKING_DEPOSIT                = 22; // Deposit destined for a Checking Account
	const CHECKING_CREDIT_PRENOTIFICATION = 23; // Prenotification for a checking credit
	const CHECKING_ZERO_DOLLAR            = 24; // Zero dollar with remittance into Checking

	const CHECKING_DEBIT_RETURN		 	 = 26;
	const CHECKING_DEBIT                 = 27; // Debit destined for a Checking Account
	const CHECKING_DEBIT_PRENOTIFICATION = 28; // Prenotification for a checking debit
	const CHECKING_DEBIT_ZERO_DOLLAR     = 29; // Zero dollar with remittance into Checking - duplicate?

	const SAVINGS_CREDIT_RETURN        	 = 31;
	const SAVINGS_DEPOSIT                = 32; // Deposit destined for a Savings Account
	const SAVINGS_CREDIT_PRENOTIFICATION = 33; // Prenotification for a savings credit
	const SAVINGS_CREDIT_ZERO_DOLLAR     = 34; // Zero dollar with remittance into Savings

	const SAVINGS_DEBIT_RETURN		 	 = 36;
	const SAVINGS_DEBIT                  = 37; // Debit destined for a Savings Account
	const SAVINGS_DEBIT_PRENOTIFICATION  = 38; // Prenotification for a Savings debit
	const SAVINGS_DEBIT_ZERO_DOLLAR      = 39; // Zero dollar with remittance into Savings


	const GL_CREDIT_RETURN			 	 = 41;
	const GL_CREDIT                      = 42; // General ledger Deposit (Credit)
	const GL_CREDIT_PRENOTIFICATION 	 = 43;
	const GL_CREDIT_ZERO_DOLLAR			 = 44;

	const GL_DEBIT_REVERSAL 			 = 46;
	const GL_DEBIT                       = 47; // General ledger Withdrawal
	const GL_DEBIT_PRENOTIFICATION       = 48; // Prenotification for General ledger Deposit (Credit)
	const GL_DEBIT_ZERO_DOLLAR			 = 49;

	const LOAN_CREDIT_REVERSAL			 = 51;
	const LOAN_CREDIT                    = 52; // Loan Deposit (Credit)
	const LOAN_CREDIT_PRENOTIFICATION    = 53; // Pre-Note: Loan Deposit (Credit)
	const LOAN_CREDIT_ZERO_DOLLAR		 = 54;

	const LOAN_REVERSAL            		 = self::LOAN_DEBIT; // Loan Reversal (Debit) (used rarely; reverses code 52)
	const LOAN_DEBIT			 		 = 55;
	const LOAN_DEBIT_RETURN 	 		 = 56;

	const CREDIT_TRANSACTION_CODES = [
		self::CHECKING_CREDIT_RETURN, self::CHECKING_DEPOSIT, self::CHECKING_CREDIT_PRENOTIFICATION, self::CHECKING_ZERO_DOLLAR,
		self::SAVINGS_CREDIT_RETURN, self::SAVINGS_DEPOSIT,self::SAVINGS_CREDIT_PRENOTIFICATION,self::SAVINGS_CREDIT_ZERO_DOLLAR,
		self::GL_CREDIT_RETURN,self::GL_CREDIT,self::GL_CREDIT_PRENOTIFICATION,self::GL_CREDIT_ZERO_DOLLAR,
		self::LOAN_CREDIT_REVERSAL,self::LOAN_CREDIT,self::LOAN_CREDIT_PRENOTIFICATION,self::LOAN_CREDIT_ZERO_DOLLAR
	];

	const DEBIT_TRANSACTION_CODES = [
		self::CHECKING_DEBIT_RETURN,self::CHECKING_DEBIT,self::CHECKING_DEBIT_PRENOTIFICATION,self::CHECKING_DEBIT_ZERO_DOLLAR,
		self::SAVINGS_DEBIT_RETURN,self::SAVINGS_DEBIT,self::SAVINGS_DEBIT_PRENOTIFICATION,self::SAVINGS_DEBIT_ZERO_DOLLAR,
		self::GL_DEBIT_REVERSAL,self::GL_DEBIT,self::GL_DEBIT_PRENOTIFICATION,self::GL_DEBIT_ZERO_DOLLAR,
		self::LOAN_DEBIT,self::LOAN_DEBIT_RETURN
	];

	public function __construct($value) {
		parent::__construct($value, 2);

		if (!self::isValid($value)) {
			throw new InvalidFieldException('Invalid transaction code "' . $value . '".');
		}
	}

	/**
	 * @param int $code
	 * @return bool
	 */
	public static function isCredit($code) {
		return in_array($code,self::CREDIT_TRANSACTION_CODES);
	}

	/**
	 * @param int $code
	 * @return bool
	 */
	public static function isDebit($code) {
		return in_array($code,self::DEBIT_TRANSACTION_CODES);
	}

	/**
	 * @param $code
	 * @return bool
	 */
	public static function isValid($code) {
		return in_array($code, array_merge(self::CREDIT_TRANSACTION_CODES,self::DEBIT_TRANSACTION_CODES));
	}

}