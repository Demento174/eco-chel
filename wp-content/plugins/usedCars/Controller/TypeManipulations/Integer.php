<?php


namespace TypeManipulations;


class Integer extends TypeManipulationsTemplate
{

	public function __construct($in)
	{
		parent::__construct($in);
	}
	public function conversionFromIntToResult(){
		return ;
	}

	public function conversionFromStringToResult(){
		$this->result = (int) $this->in;
	}

	public function conversionFromArrayToResult(){
		$this->result = count($this->in);
	}

	public function conversionFromBoolToResult(){
		$this->result = (int) $this->in;
	}
}