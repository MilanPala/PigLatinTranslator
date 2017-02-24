<?php

include __DIR__ . '/../vendor/autoload.php';

$translator = new App\PigLatinTranslator();

Tester\Assert::exception(function() {
    $translator = new App\PigLatinTranslator();
    $translator->into('happy');
}, \RuntimeException::class);

$translator->setFacilityDelimiter(App\PigLatinTranslator::HYPHEN_DELIM);

$translator->setDialect(new App\PigLatinGeneralDialect);
Tester\Assert::same( 'appy-hay', $translator->into('happy') );
Tester\Assert::same( 'estion-quay', $translator->into('question') );
Tester\Assert::same( 'ar-stay', $translator->into('star') );
Tester\Assert::same( 'ee-thray', $translator->into('three') );
Tester\Assert::same( 'eagle-ay', $translator->into('eagle') );

$translator->setDialect(new App\PigLatinGeneralHDialect);
Tester\Assert::same( 'appy-hay', $translator->into('happy') );
Tester\Assert::same( 'eagle-hay', $translator->into('eagle') );

$translator->setFacilityDelimiter(App\PigLatinTranslator::APOSTROF_DELIM);
Tester\Assert::same( 'appy\'hay', $translator->into('happy') );
Tester\Assert::same( 'eagle\'hay', $translator->into('eagle') );
