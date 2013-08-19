<?php

interface IPigLatinDialect
{
	/**
	 * Pokud slovo začíná samohláskou
	 */
	public function vowelForm($what, $facilityDelimiter);
	
	/**
	 * Pokud slovo začíná souhláskou
	 */
	public function consonantForm($what, $where, $facilityDelimiter);
}
