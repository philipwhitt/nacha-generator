[![Build Status](https://drone.io/github.com/philipwhitt/nacha-generator/status.png)](https://drone.io/github.com/philipwhitt/nacha-generator/latest)

NACHA File Generator
====================

Based on documentation from NACHA:
https://www.nacha.org/system/files/resources/AAP201%20-%20ACH%20File%20Formatting.pdf

Currently, there is no validation for field inputs. Strings that are too long will be truncated. Required/mandatory are currently not enforced.

###Install With Composer
```
{
	"require" : {
		"nacha/file-generator" : "dev-master"
	}
}
```

###Usage
```php
<?php
use Nacha\File;
use Nacha\Batch;
use Nacha\Record\DebitEntry;
use Nacha\Record\CcdEntry;

// Create the file and set the proper header info
$file = new File();
$file->setImmediateDestination('051000033')
	...
	->setReferenceCode('MYCODE');

// Create a batch and add some entries
$batch = new Batch();
$batch->getHeader()
	...
	->setOriginatingDFiId('01021234');

$batch->addDebitEntry((new DebitEntry)
	...
	->setTraceNumber('99936340000015'));

$file->addBatch($batch);

// completed file ready for output
$output = (string)$file);

```

For complete examples see test/Nacha/FileTest.php

###Tests
```
$ ./vendor/bin/phpunit -c test/ci.xml
```
