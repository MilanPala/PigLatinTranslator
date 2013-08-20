<?php

require '../tester-0.9.3/Tester/bootstrap.php';
require 'PigLatinTranslator.php';
require 'PigLatinGeneralDialect.php';
require 'PigLatinGeneralHDialect.php';

use Tester\Assert;

$translator = new PigLatinTranslator();

Assert::exception(function() {
    $translator = new PigLatinTranslator();
    $translator->into('happy');
}, 'RuntimeException');

$translator->setFacilityDelimiter(PigLatinTranslator::HYPHEN_DELIM);

$translator->setDialect(new PigLatinGeneralDialect);
Assert::same( 'appy-hay', $translator->into('happy') );
Assert::same( 'estion-quay', $translator->into('question') );
Assert::same( 'ar-stay', $translator->into('star') );
Assert::same( 'ee-thray', $translator->into('three') );
Assert::same( 'eagle-ay', $translator->into('eagle') );

$translator->setDialect(new PigLatinGeneralHDialect);
Assert::same( 'appy-hay', $translator->into('happy') );
Assert::same( 'eagle-hay', $translator->into('eagle') );

$translator->setFacilityDelimiter(PigLatinTranslator::APOSTROF_DELIM);
Assert::same( 'appy\'hay', $translator->into('happy') );
Assert::same( 'eagle\'hay', $translator->into('eagle') );