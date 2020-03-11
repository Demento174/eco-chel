<?php

namespace View;
use Timber;

Class Render {
	public $view;
	public $data;
	public $errors = 'Шаблон Вывода не найден';

	function __construct($view,$data=[],$error=''){
		$this->view=$view;

		$this->data=$data;

		$this->render();
	}

	public function render(){


		if(!file_exists(demento_dir().dirname('/views/'.$this->view.'-view.twig',2))){

			$this->view='404';

			$this->data=['message'=>$this->errors];
		}

		Timber::render($this->view.'-view.twig',$this->data);
	}
}