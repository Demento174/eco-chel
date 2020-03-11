<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also defines a function that starts the plugin.
 *
 * @link              http://
 * @since             1.0.0
 * @package           Car-price
 *
 * @wordpress-plugin
 * Plugin Name:       Demento
 * Plugin URI:        http://code.tutsplus.com/tutorials/creating-custom-admin-pages-in-wordpress-1
 * Description:       MustHave
 * Version:           1.0.0
 * Author:            Demento
 * Author URI:        https://demento174.ru
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

use Menu\SubMenu;

if ( ! defined( 'WPINC' )   ) {
	return false;
}

if(is_admin() && !is_plugin_active('timber-library/timber.php')){

	run_activate_plugin( 'timber-library/timber.php' );

}

foreach ( glob( plugin_dir_path( __FILE__ ) . 'include/*.php' ) as $file ) {

	include_once $file;
}




add_action('admin_head', 'wph_add_css_file_admin');

function wph_add_css_file_admin() {
	wp_enqueue_style('usedCars-style-admin', plugins_url('usedCars') .'/assests/less/style.css');
	wp_enqueue_script('usedCars-script-admin', plugins_url('usedCars') .'/assests/js/common.js');
	wp_localize_script( 'usedCars-script-admin', 'myajax',
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);
}

add_action( 'plugins_loaded', 'menu' );
function menu() {
	$mainMenu = new Menu\MainMenu('Настройки Администратора','admin-options',NULL,NULL,3);
	new Menu\SubMenu($mainMenu,'Произвольные типы записей','admin-options','\CustomPosts\CustomPostsOut');
	new Menu\SubMenu($mainMenu,'AJAX Функции','simpleAjax','\SimpleAjax\SimpleAjaxOut');
	init();
}

function init(){

    new \SimpleAjax\SimpleAjaxInit();
}
