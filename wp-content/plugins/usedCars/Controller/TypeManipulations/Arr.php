<?php


namespace TypeManipulations;


class Arr extends TypeManipulationsTemplate
{
	public function __construct($in)
	{
		parent::__construct($in);
	}

	public function conversionFromIntToResult(){
		$int = preg_split('//',$this->in);
		array_pop($int);
		array_shift($int);
		$this->result = $int;
	}

	public function conversionFromStringToResult(){
		$this->result=(int) $this->in;
	}

	public function conversionFromArrayToResult(){
		return;
	}

	public function conversionFromBoolToResult(){

		$this->result[0] = $this->in;
	}
}