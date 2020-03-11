<?php
namespace TypeManipulations;

abstract class TypeManipulationsTemplate{
	public $method;

	public $in;

	function __construct($in){
		$this->in = $in;

		$this->switchType();

		return $this->method;
	}

	abstract function conversionFromIntToResult();

	abstract function conversionFromStringToResult();

	abstract function conversionFromArrayToResult();

	abstract function conversionFromBoolToResult();

	private function switchType(){
		switch (gettype($this->in)){
			case 'integer':
				$this->method='conversionFromIntToResult';
				break;

			case 'string':
				$this->method='conversionFromStringToResult';
				break;

			case 'array':
				$this->method='conversionFromArrayToResult';
				break;

			case 'boolean':
				$this->method='conversionFromBoolToResult';
				break;
		}
	}
}