<?php
namespace CustomPosts;

use TypeManipulations\TypeManipulations;

Class CustomPostsOut extends CustomPosts{
	private $view = 'custom-post/custom-posts';

	public $data;


	function __construct(){

		return new \View\Render($this->view,$this->getData());
	}

	function getData(){
		$args = $this->getArgs();

		foreach ($args as $key=>$item){

			$string = new TypeManipulations($item['value'],'string');
			$args[$key]['value']= $string->getResult();
			unset($string);
		}

		return $this->data =[
			'posts'=>$this->getPostsType(),
			'fields'=>[
				'slug'=>$this->getSlug(),
				'labels'=>$this->getLabels(),
				'args'=>$args,
			],
		];

	}

	private function getPostsType(){
	    return get_post_type();
    }

}