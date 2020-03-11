<?php


$data = [
	'Controller/Menu/MainMenu',
	'Controller/Menu/SubMenu',

	'Controller/View/Render',

	'Controller/CustomPosts/CustomPosts',
	'Controller/CustomPosts/CustomPostsRegister',
	'Controller/CustomPosts/CustomPostsOut',

	'Controller/TypeManipulations/TypeManipulationsTemplate',
	'Controller/TypeManipulations/TypeManipulations',
	'Controller/TypeManipulations/Arr',
	'Controller/TypeManipulations/Boolean',
	'Controller/TypeManipulations/Integer',
	'Controller/TypeManipulations/Str',

	'Controller/DB/Db',

    'Controller/Translit/Translit',

    'Controller/SimpleAjax/SimpleAjaxTemplate',
    'Controller/SimpleAjax/SImpleAjax',
    'Controller/SimpleAjax/SimpleAjaxInit',
    'Controller/SimpleAjax/SimpleAjaxOut',
    'Controller/SimpleAjax/SimpleAjaxDB',

    'Controller/FrontendMenu/HeaderMenu',
    'Controller/FrontendMenu/FooterMenu',
];


classLoad($data);


function demento_dir(){
    return plugin_dir_path(  __DIR__);
}

function classLoad($data=[]){
	foreach ($data as $file){

		$file = demento_dir() . $file . '.php';

		if (!file_exists($file)) {

			throw new \Exception("File is not found: {$file}");

		}

		require_once $file;
	}
}