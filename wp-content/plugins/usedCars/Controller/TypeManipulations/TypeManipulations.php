<?php


namespace TypeManipulations;


class TypeManipulations
{
	public $class;

	public $bool='\TypeManipulations\Boolean';

	public $integer='\TypeManipulations\Integer';

	public $string='\TypeManipulations\Str';

	public $arr='\TypeManipulations\Arr';

	public $result;

	public function __construct($in,$out){
		$this->switchOut($out);

		$result =new $this->class($in);

		$this->result=$result->result;

	}

	public function getResult (){
		return $this->result;
	}

	public function switchOut($out){
		switch ($out){
			case 'integer':
				$this->class=$this->integer;
				break;

			case 'string':
				$this->class=$this->string;
				break;

			case 'array':
				$this->class=$this->arr;
				break;

			case 'boolean':
				$this->class=$this->bool;
				break;
		}
	}
}