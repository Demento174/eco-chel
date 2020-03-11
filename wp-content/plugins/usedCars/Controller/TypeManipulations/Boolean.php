<?php


namespace TypeManipulations;


class Boolean extends TypeManipulationsTemplate
{
	public function __construct($in, $type)
	{
		parent::__construct($in, $type);
	}
	public function conversionFromIntToResult(){
		$this->result = (bool) $this->in;
	}

	public function conversionFromStringToResult(){
		$this->result = (bool) $this->in;
	}

	public function conversionFromArrayToResult(){
		$this->result = (bool) $this->in;
	}

	public function conversionFromBoolToResult(){
		return;
	}
}