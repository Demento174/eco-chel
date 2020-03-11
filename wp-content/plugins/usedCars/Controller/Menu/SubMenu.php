<?php
namespace Menu;



use CustomPosts\CustomPostsOut;

Class SubMenu{

	public $parent_slug;

	public $title;

	public $slug;

	public $controller;

	public $capability;

	function __construct($parent,$title,$slug,$controller){

		$this->parent_slug = $parent->slug;

		$this->title       = $title;

		$this->slug        = $slug;

		$this->capability  = $parent->capability;

		$this->controller  = $controller;

		$this->init();
	}

	function init(){
		add_action( 'admin_menu', array( $this, 'add_submenu_page' ) );
	}

	function add_submenu_page(){
		add_submenu_page(
			$this->parent_slug,
			$this->title,
			$this->title,
			$this->capability,
			$this->slug,
			[$this,'out']
		);
	}

	function out(){

		return new $this->controller;
	}

}