<?php

require_once 'PigLatinTranslator.php';
require_once 'PigLatinGeneralDialect.php';
require_once 'PigLatinGeneralHDialect.php';

header('Content-type: text/plain');

$translator = new PigLatinTranslator();

$translator->setFacilityDelimiter(PigLatinTranslator::HYPHEN_DELIM);
//$translator->setFacilityDelimiter(PigLatinTranslator::APOSTROF_DELIM);

$words = array('happy', 'beast', 'dough', 'question', 'star', 'three', 'eagle');


// Ukázka nad běžným jazykem
$translator->setDialect(new PigLatinGeneralDialect());

echo "General\n=======\n";
foreach($words as $word)
{
	echo $word.' = '.$translator->into($word)."\n";
}


// Ukázka nad dialektem s H
$translator->setDialect(new PigLatinGeneralHDialect);

echo "\n\nGeneral+h\n=========\n";
foreach($words as $word)
{
	echo $word.' = '.$translator->into($word)."\n";
}
