<?php

namespace Nacha\Field;

class StandardEntryClass extends String {

	const ACK = 'ACK';
	const ADV = 'ADV';
	const ARC = 'ARC';
	const ATX = 'ATX';
	const BOC = 'BOC';
	const CCD = 'CCD';
	const CIE = 'CIE';
	const COR = 'COR';
	const CTX = 'CTX';
	const DNE = 'DNE';
	const ENR = 'ENR';
	const MTE = 'MTE';
	const POS = 'POS';
	const PPD = 'PPD';
	const POP = 'POP';
	const RCK = 'RCK';
	const SHR = 'SHR';
	const TEL = 'TEL';
	const TRC = 'TRC';
	const TRX = 'TRX';
	const WEB = 'WEB';
	const XCK = 'XCK';

	private $validClasses = [
		self::ACK, self::ADV, self::ARC, self::ATX, self::BOC, self::CCD, self::CIE, self::COR, self::CTX, self::DNE, self::ENR,
	 	self::MTE, self::POS, self::PPD, self::POP, self::RCK, self::SHR, self::TEL, self::TRC, self::TRX, self::WEB, self::XCK,
	 ];

	public function __construct($value) {
		$value = strtoupper($value);

		parent::__construct($value, 3);

		if (!in_array($value, $this->validClasses)) {
			throw new InvalidFieldException($value.' is not a valid standard entry class.');
		}
	}
}
