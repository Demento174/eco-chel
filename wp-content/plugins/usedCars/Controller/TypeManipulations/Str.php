<?php


namespace TypeManipulations;


class Str extends TypeManipulationsTemplate
{
	public $result;

	public function __construct($in)
	{
		$method =  parent::__construct($in);
		$this->result = $this->$method();
	}

	public function conversionFromIntToResult(){
		return (string) $this->in;
	}

	public function conversionFromStringToResult(){
		return (string) $this->in;;
	}

	public function conversionFromArrayToResult(){
		$result = '';
		foreach ($this->in as $item){

			$string = new TypeManipulations($item,'string');

			$result.= $string->getResult();

			$result.=', ';
		}

		return $result;
	}

	public function conversionFromBoolToResult(){

		return (int) $this->in==1?'TRUE':'FALSE';
	}
}