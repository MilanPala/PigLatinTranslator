<?php

require 'IPigLatinDialect.php';

class PigLatinTranslator
{

  /** @var IPigLatinDialect */
	private $dialect = null;
	
	private $facilityDelimiter = '';

	const HYPHEN_DELIM = '-';
	const APOSTROF_DELIM = '\'';
	
	/**
	 * Nastaví dialekt jazyka
	 * @param IPigLatinDialect $dialect
	 */
	public function setDialect(IPigLatinDialect $dialect)
	{
		$this->dialect = $dialect;
	}
	
	public function setFacilityDelimiter($delimiter)
	{
		$this->facilityDelimiter = $delimiter;
	}

	/**
	 * Funkce se pokusí nalézt pozici ve slově, kde by se slovo mělo rozdělit
	 * @param string Slovo, které se má rozdělit
	 * @return int Pozice znaku, který jako první patří do druhé poloviny slova, jinak -1, pokud se slovo nedělí
	 * @throws RuntimeException
	 */
	private function split($what)
	{
		$vowels = array('a', 'e', 'i', 'o', 'u');

		/**
		 * Konečný automat, který rozhodne, kde se slovo má rozdělit
		 * INIT ... počáteční stav
		 * VOWEL ... slovo začíná samohláskou => konec
		 * QCLUSTER ... slovo začíná písmenem Q, může následovat U a pak se nedělí
		 * CONS ... slovo obsahuje jako prefix souhlásky, čeká se na samohlásku
		 * CONSCLUSTER ... slovo obsahuje jako prefix souhlásky ukončené samohláskou => konec
		 */
		$state = 'INIT';
		$i = 0;
		$c = $what[$i];
		do
		{
			switch ($state)
			{
				case 'INIT':
					if (in_array($c, $vowels)) $state = 'VOWEL';
					elseif (in_array($c, array('q'))) $state = 'QCLUSTER';
					else $state = 'CONS';
					break;

				case 'QCLUSTER':
					if (in_array($c, array('u'))) $state = 'CONS';
					else $state = 'CONS';
					break;

				case 'CONS':
					if (in_array($c, $vowels)) $state = 'CONSCLUSTER';
					else $state = 'CONS';
					break;

				case 'VOWEL':
					return -1;

				case 'CONSCLUSTER':
					return $i - 1;

				default:
					throw new RuntimeException('Bad state');
			}
			$i++;
			if ($i == strlen($what)) return $i; // slovo dosáhlo konce, byly pouze souhlásky
			$c = $what[$i];
		} while (true);
	}

	/**
	 * Přeloží vstup do pig-latin
	 * @param string $what Vstup k přeložení
	 * @return string Výsledek v pig-latin
	 * @throws RuntimeException
	 */
	public function into($what)
	{
		if ($this->dialect === null)
		{
			throw new RuntimeException('Dialect has not been set.');
		}

		if (($split = $this->split($what)) === -1)
		{
			return $this->dialect->vowelForm($what, $this->facilityDelimiter);
		} else
		{
			return $this->dialect->consonantForm($what, $split, $this->facilityDelimiter);
		}
	}

}