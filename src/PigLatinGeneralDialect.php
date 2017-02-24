<?php

namespace App;

class PigLatinGeneralDialect implements IPigLatinDialect
{
	protected $extraConsonant = '';
	protected $suffix = 'ay';
	
	public function vowelForm($what, $facilityDelimiter)
	{
		return $what . $facilityDelimiter . $this->extraConsonant . $this->suffix;
	}

	public function consonantForm($what, $where, $facilityDelimiter)
	{
		return substr($what, $where) . $facilityDelimiter . substr($what, 0, $where) . $this->suffix;
	}	
}
