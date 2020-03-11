<?php


function run_activate_plugin( $plugin ) {
	$current = get_option( 'active_plugins' );
	$plugin = plugin_basename( trim( $plugin ) );

	if ( !in_array( $plugin, $current ) ) {
		$current[] = $plugin;
		sort( $current );
		do_action( 'activate_plugin', trim( $plugin ) );
		update_option( 'active_plugins', $current );
		do_action( 'activate_' . trim( $plugin ) );
		do_action( 'activated_plugin', trim( $plugin) );
	}

	return null;
}




/**
 * TWIG
 */

add_filter( 'timber/twig', function( \Twig_Environment $twig ) {
	$twig->addFunction( new Timber\Twig_Function( 'get_field', 'get_field' ) );
	$twig->addFunction( new Timber\Twig_Function( 'wp_footer', 'wp_footer' ) );
	$twig->addFunction( new Timber\Twig_Function( 'wp_head', 'wp_head' ) );
    $twig->addFunction( new Timber\Twig_Function( 'get_the_post_thumbnail_url', 'get_the_post_thumbnail_url' ) );
    $twig->addFunction( new Timber\Twig_Function( 'wp_menu_header', 'wp_menu_header' ) );
    $twig->addFunction( new Timber\Twig_Function( 'wp_menu_footer', 'wp_menu_footer' ) );
    $twig->addFunction( new Timber\Twig_Function( 'get_page_link', 'get_page_link' ) );
    $twig->addFunction( new Timber\Twig_Function( 'get_terms_title', 'get_terms_title' ) );
    $twig->addFunction( new Timber\Twig_Function( 'get_template_directory_uri', 'get_template_directory_uri' ) );
    $twig->addFunction( new Timber\Twig_Function( 'dump', 'dump' ) );

	return $twig;
} );

\Timber\Timber::$locations = array(
    demento_dir() . 'views/',
    get_template_directory().'/template-parts/',
);

add_filter( 'timber/cache/mode', function () {
    return 'none';
} );

function wp_menu_header($theme_location='',$menu=''){

    wp_nav_menu( [
        'theme_location'  => 'header_menu',
        'menu'            => '',
        'container'       => false,
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'main-nav__list',
        'menu_id'         => 'header_menu',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth'           => 0,
        'walker'          => new \FrontendMenu\HeaderMenu,
    ] );
}

function wp_menu_footer($theme_location='',$menu=''){

    wp_nav_menu( [
        'theme_location'  => 'footer_menu',
        'menu'            => '',
        'container'       => false,
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'footer-nav__list',
        'menu_id'         => 'footer_menu',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth'           => 0,
        'walker'          => new \FrontendMenu\FooterMenu,
    ] );
}


/**
 * debugging
 */

function dump($data){
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

function xprint( $param, $title = 'Отладочная информация' )
{
	ini_set( 'xdebug.var_display_max_depth', 50 );
	ini_set( 'xdebug.var_display_max_children', 25600 );
	ini_set( 'xdebug.var_display_max_data', 9999999999 );
	if ( PHP_SAPI == 'cli' )
	{
		echo "\n---------------[ $title ]---------------\n";
		echo print_r( $param, true );
		echo "\n-------------------------------------------\n";
	}
	else
	{
		?>
		<style>
			.xprint-wrapper {
				padding: 10px;
				margin-bottom: 25px;
				color: black;
				background: #f6f6f6;
				position: relative;
				top: 18px;
				border: 1px solid gray;
				font-size: 11px;
				font-family: InputMono, Monospace;
				width: 80%;
			}
			.xprint-title {
				padding-top: 1px;
				color: #000;
				background: #ddd;
				position: relative;
				top: -18px;
				width: 170px;
				height: 15px;
				text-align: center;
				border: 1px solid gray;
				font-family: InputMono, Monospace;
			}
		</style>
		<div class="xprint-wrapper">
		<div class="xprint-title"><?= $title ?></div>
		<pre style="color:#000;"><?= htmlspecialchars( print_r( $param, true ) ) ?></pre>
		</div><?php
	}
}


function logs($txt = "")
{
	try{
		$fp = fopen(__DIR__ . "/log_new.txt", "a"); // Открываем файл в режиме записи
		if(is_array($txt)){

			fwrite($fp,"\n". date("d-m-Y_H:i:s")." -- > ".print_r($txt,TRUE));

		}else{
			fwrite($fp,"\n". date("d-m-Y_H:i:s")." -- > ".$txt);
		}


		fclose($fp); //Закрытие файла
	}catch (Exception $e) { return false; }

	return true;
}
