<?php
namespace CustomPosts;

abstract class CustomPosts{

	public $slug;

	public $labels =[
		'name'               =>[
			'value'=>'',
			'ru'=>'Имя'
		],
		'singular_name'      =>[
			'value'=>'',
			'ru'=>'Имя в ед. числе'
		],
		'add_new'            =>[
			'value'=>'',
			'ru'=>'Добавить новое..'
		],
		'add_new_item'       =>[
			'value'=>'',
			'ru'=>'добавить новый ед.число'
		],
		'edit_item'          =>[
			'value'=>'',
			'ru'=>'Редактировать ед.число'
		],
		'new_item'           =>[
			'value'=>'',
			'ru'=>'Новый ед.число'
		],
		'view_item'          =>[
			'value'=>'',
			'ru'=>'Посмотреть ед.число'
		],
		'search_items'       =>[
			'value'=>'',
			'ru'=>'Искать множ.число'
		],
		'not_found'          =>[
			'value'=>'',
			'ru'=>'Не найден'
		],
		'not_found_in_trash' =>[
			'value'=>'',
			'ru'=>'Не найден в корзине'
		],
		'parent_item_colon'  =>[
			'value'=>'',
			'ru'=>'Родитель элемента'
		],
		'menu_name'          =>[
			'value'=>'',
			'ru'=>'Название в меню'
		]
	];

	public $args = [
		'show_in_menu' =>[
			'value'=>false,
			'ru'=>'Показывать ли тип записи в администраторском меню и где именно показывать управление типом записи. Аргумент show_ui должен быть включен!'

		],
		'hierarchical' =>[
			'value'=>false,
			'ru'=>'Будут ли записи этого типа иметь древовидную структуру (как постоянные страницы)'

		],
		'supports' =>[
			'value'=>['title', 'thumbnail', 'editor','custom-fields'],
			'ru'=>'Вспомогательные поля на странице создания/редактирования этого типа записи. Метки для вызова функции add_post_type_support()'

		],
		'public' =>[
			'value'=>true,
			'ru'=>'Определяет является ли тип записи публичным или нет. На основе этого параметра строятся много других, т.е. это своего рода пред-установка для следующих параметров:'

		],
		'map_meta_cap'=>[
			'value'=>true,
			'ru'=>'Ставим true, чтобы включить дефолтный обработчик специальных прав map_meta_cap(). Он преобразует неоднозначные права (edit_post - один пользователь может, а другой нет) в примитивные (edit_posts - все пользователи могут). Обычно для типов постов этот параметр нужно включать, если типу поста устанавливаются особые права (отличные от \'post\').'

		],
		'show_ui' =>[
			'value'=>true,
			'ru'=>'Показывать ли тип записи в администраторском меню и где именно показывать управление типом записи. Аргумент show_ui должен быть включен!'
		],
		'menu_position'=>[
			'value'=>1,
			'ru'=>'Позиция где должно расположится меню нового типа записи:'
		],
		'menu_icon'=>[
			'value'=>'',
			'ru'=>'Ссылка на картинку, которая будет использоваться для этого меню.(<a href="https://developer.wordpress.org/resource/dashicons/">Dashicons</a>)'

		],
		'show_in_nav_menus'=>[
			'value'=>false,
			'ru'=>'Включить возможность выбирать этот тип записи в меню навигации'
		],
		'publicly_queryable'=>[
			'value'=>true,
			'ru'=>'Запросы относящиеся к этому типу записей будут работать во фронтэнде (в шаблоне сайта)'
		],
		'exclude_from_search' =>[
			'value'=>false,
			'ru'=>'Исключить ли этот тип записей из поиска по сайту. 1 (true) - да, 0 (false) - нет'
		],
		'has_archive' =>[
			'value'=>true,
			'ru'=>'Включить поддержку страниц архивов для этого типа записей (пр. УРЛ записи выглядит так: site.ru/type/post_name, тогда УРЛ архива будет такой: site.ru/type.'
		],
		'query_var' =>[
			'value'=>true,
			'ru'=>'Устанавливает название параметра запроса для создаваемого типа записи.'
		],
		'can_export'=>[
			'value'=>false,
			'ru'=>'Возможность экспорта этого типа записей.'
		],
		'rewrite'=>[
			'value'=>true,
			'ru'=>'Использовать ли ЧПУ для этого типа записи. Чтобы не использовать ЧПУ укажите false. По умолчанию: true — название типа записи используется как префикс в ссылке. Можно в массиве указать дополнительные параметры для построения ЧПУ:'
		],
		'capability_type'=>[
			'value'=>'page',
			'ru'=>'используется для построения списка прав, которые будут записаны в параметр \'capabilities\'.'
		],
	];


	public function setSlug($slug){
		$this->slug=$slug;
	}

	public function getSlug(){
		return $this->slug;
	}


	public function setArgs($args){

		foreach ($this->args as $key=>$item){
			$this->args[$key]=isset($args[$key])?$args[$key]:$this->args[$key];
		}
	}

	public function getArgs(){
		return $this->args;
	}

	public function setLabels($labels){
		foreach ($this->labels as $key=>$item){
			$this->labels[$key]=isset($labels[$key])?$labels[$key]:$this->labels[$key];
		}
	}

	public function getLabels(){

		return $this->labels;
	}


}