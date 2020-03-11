<?php
/**
 * Printmetalls functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Printmetalls
 * @since 1.0
 */

/**
 * Main setup
 */
add_action( 'after_setup_theme', 'template_setup');
function template_setup() {

    load_theme_textdomain( 'template', get_template_directory() . '/languages' );

    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'post-thumbnails' );

    register_nav_menus( array(
        'header_menu' => 'Основное меню',
        'footer_menu' => 'Меню в подвале'
    ) );

    add_theme_support( 'title-tag' );

    add_theme_support( 'post-thumbnails' );

    add_theme_support( 'html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ) );

    add_theme_support( 'customize-selective-refresh-widgets' );

}

/**
 * connect js scripts and css in head
 */

add_action( 'wp_enqueue_scripts', 'template_scripts' );
function template_scripts(){
    global $post;
    //common
    wp_enqueue_script( 'template-js-jquery', get_template_directory_uri().'/libs/jquery.min.js', array(), '3.3.1');
    wp_enqueue_script( 'template-js-javaScript', get_template_directory_uri().'/assets/js/main.js', array());
    wp_enqueue_script( 'template-js-CommonJavaScript', get_template_directory_uri().'/assets/js/common.js', array());
    wp_enqueue_style('template-script-common', get_template_directory_uri().'/assets/css/main.css');
    wp_localize_script( 'template-js-CommonJavaScript', 'myajax',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );

    if($post->ID == 7 || $post->ID == 1169 || is_tax( 'product_cat' )){
        global $wp_query;

        wp_enqueue_script( 'template-js-loadmore', get_template_directory_uri().'/assets/js/loadmore.js', array());

        wp_localize_script( 'template-js-loadmore', 'loadmore',
            array(
                'ajax'         => admin_url('admin-ajax.php'),
                'tax'   => get_queried_object()->taxonomy,
                'term_taxonomy_id'=>get_queried_object()->term_taxonomy_id,
                'current_page' => get_query_var('pag')?get_query_var('pag'):1,
                'max_pages'    => $wp_query->max_num_pages,
            )
        );
    }
     //FONTS
    wp_enqueue_style('template-style-fonts', get_template_directory_uri().'/assets/fonts/fonts.css');

    //Bootstrap
//    wp_enqueue_style('template-style-bootstrap', get_template_directory_uri().'/libs/bootstrap/bootstrap.min.css');
//    wp_enqueue_script( 'template-js-bootstrap', get_template_directory_uri().'/libs/bootstrap/bootstrap.js', array(), '412');

    //font_awesome
//    wp_enqueue_style('template-style-font_awesome', get_template_directory_uri().'/libs/awesome/all-min.css');
//    wp_enqueue_script( 'template-js-font_awesome', get_template_directory_uri().'/libs/awesome/all-min.js');

    //fancybox
//    wp_enqueue_script( 'template-js-fancybox', get_template_directory_uri().'/libs/fancybox/jquery.fancybox.min.js', array());
//    wp_enqueue_style('template-style-fancybox', get_template_directory_uri().'/libs/fancybox/jquery.fancybox.min.css');

    //owl
//    wp_enqueue_script( 'template-js-owl', get_template_directory_uri().'/libs/owl/owl.min.js', array());
//    wp_enqueue_style('template-style-owl', get_template_directory_uri().'/libs/owl/owl.min.css');
//    wp_enqueue_style('template-style-owl', get_template_directory_uri().'/libs/owl/owl.theme.min.css');
}

/**
 * Static front page
 */
add_filter( 'frontpage_template',  'template_front_page_template' );
function template_front_page_template( $template ) {
    return is_home() ? '' : $template;
}

/**
 * Menu to ACF plugin
 */
$args = array(

    'page_title' => 'Настройка Сайта',

    'menu_title' => 'Настройка Сайта',

    'menu_slug' => 'option_site',

    'position' => 25,

    'parent_slug' => '',

    'icon_url' => 'dashicons-admin-tools',

    'redirect' => true,

    'post_id' => 'options',

    'autoload' => false,

    'update_button'		=> __('Update', 'acf'),

    'updated_message'	=> __("Options Updated", 'acf')
);

acf_add_options_page( $args );

/**
 * logo and backGround Admin panel
 */

add_action('login_head', 'custom_login_page');

add_action('login_head', 'my_custom_login_logo');

add_action('add_admin_bar_menus', 'reset_admin_wplogo');

function custom_login_page() {

    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo( 'template_directory' ) . '/css/admin.css" />';
}

function my_custom_login_logo(){

    echo '<style type="text/css">
	
	h1 a { background-image:url('.get_bloginfo('template_directory').'assets/img/logo_admin.png) !important; }
	
	</style>';
}

function reset_admin_wplogo(  ){

    remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 ); // удаляем стандартную панель (логотип)

    add_action( 'admin_bar_menu', 'my_admin_bar_wp_menu', 10 ); // добавляем свою
}

function my_admin_bar_wp_menu( $wp_admin_bar ) {

    $wp_admin_bar->add_menu( array(

        'id'    => 'wp-logo',

        'title' => '<img style="max-width:40px;height:40px;" src="'. get_bloginfo('template_directory') .'/assets/img/logo_admin.png" alt="" >', // иконка dashicon

        'href'  => home_url('/about/'),

        'meta'  => array(

            'title' => 'О моем сайте',
        ),
    ) );
}


/**
Announcement of the article
 */
function the_truncated_post($post) {

    $filtered = strip_tags( preg_replace('@<style[^>]*?>.*?</style>@si', '', preg_replace('@<script[^>]*?>.*?</script>@si', '',$post->post_content)) );

    echo substr($filtered, 0, strrpos(substr($filtered, 0, 450), ' ')) . '...';
}


/**
 * upload social icons
 * gets parameters name social icon or all
 */
function social_icon($socNet=''){

    $social_array=get_field('social_networks','option');

    $social_icons=array();

    $social_icons_bar='';

    $color='';

    foreach ($social_array as $item){

        $social_title=$item['social_title'];

        unset($item['social_title']);

        $social_icons[$social_title]=$item;
    }

    if($socNet=='all'){

        foreach ($social_icons as $key=> $item){

            $icon=$item['social_icon'];

            $key!=='instagram' ? $color=$item['social_color'] : $color='linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%)';

            $link=$item['social_link'];

            $social_icons_bar.='<span class="social_icon" style="background: '.$color.'">';

            $social_icons_bar.='<a href='.$link.' target="_blank">'.$icon.'</a>';

            $social_icons_bar.='</span>';

        }


    }elseif (isset($social_icons[$socNet])){

        $color='';

        $icon=$social_icons[$socNet]['social_icon'];

        $socNet!=='instagram' ? $color=$social_icons[$socNet]['social_color'] : $color='linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%)';

        $link=$social_icons[$socNet]['social_link'];

        $social_icons_bar='<span class="social_icon" style="background: '.$color.'">';

        $social_icons_bar.='<a href='.$link.' target="_blank">'.$icon.'</a>';

        $social_icons_bar.='</span>';


    }else{

        return '';

    }



    return $social_icons_bar;
}


/**
 * disable wp editor
 */
add_action( 'admin_init', 'disable_content_editor' );
function disable_content_editor() {

    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

    if( !isset( $post_id ) ) return;

    $template_file = get_post_meta($post_id, '_wp_page_template', true);

    remove_post_type_support( 'page', 'editor' );


}

/**
 * terms title
 */

function get_terms_title($terms=[]){
    $str='';
    if($terms){
        foreach ($terms as $item){
            $str.=$item->name;
            if($item !== end($terms)) {
                $str.=', ';
            }
        }
    }
    return $str;
}

/**
 * Body Class
 */

add_filter( 'body_class','my_body_class' );
function my_body_class( $classes ) {
    global $post;


    if( $post->post_type =='product' )
    {
        $classes[] = 'product-page page';
    }elseif (is_page(7)){
        $classes[] = 'page page-catalog';
    }elseif (is_page(71)){
        $classes[] = 'page page-cart';
    }elseif (is_page(13)){
        $classes[] = 'page-contacts';
    }



    return $classes;
}
/**
 * disable menu item
 */
add_action('admin_menu', 'remove_admin_menu');
function remove_admin_menu() {
//    remove_menu_page('plugins.php'); // Плагины
//    remove_menu_page('edit.php'); // Посты блога
//    remove_menu_page('upload.php'); // Медиабиблиотека
    remove_menu_page('edit-comments.php'); // Комментарии
//    remove_menu_page('themes.php'); // Внешний вид
    //remove_menu_page('edit.php?post_type=page'); // Страницы
//    remove_menu_page('options-general.php');  //Удаляем раздел Настройки
//    remove_menu_page('tools.php'); // Инструменты
//    remove_menu_page('users.php'); // Пользователи
    remove_menu_page('link-manager.php'); // Ссылки
}

/**
 * Register taxonome
 */
add_action ( 'init', 'create_tax_product' );
function create_tax_product(){
    $labels = array(
        'name' => _x('Марки', 'taxonomy general name'),
        'singular_name' => _x('Марки', 'taxonomy singular name'),
        'search_items' => __('Поиск по категориям'),
        'all_items' => __('Все Марки'),
        'parent_item' => __('Родительская категория'),
        'parent_item_colon' => __('Родительская категория:'),
        'edit_item' => __('Редактировать категорию'),
        'update_item' => __('Обновить категорию'),
        'add_new_item' => __('Добавить новую категорию'),
        'new_item_name' => __('Имя новой категории'),
        'menu_name' => __('Марки'),
    );

    register_taxonomy('tax_marks', array('product'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true
    ));

}

/**
 * Header && Footer
 **/

add_action('wp_body_open','header_open');
//add_action( 'embed_footer', 'footer_open' );

function header_open(){

    $header=[
        'logo'=>get_field('logo','options'),
        'phone'=>get_field('phone','options'),
        'link'=>!is_front_page()?'href="'.get_home_url().'"':'',
        'count'=>WC()->cart->get_cart_contents_count()

    ];

    Timber::render('/blocks/base/header-menu.twig',$header);
    if(is_front_page()){
        Timber::render('/index/index-h1.twig',
            [
                'h1'=>get_field('h1', 25),
                'background'=>get_field('background',25)['url']
            ]
        );
    }
    $marks=get_terms( [
        'taxonomy' => 'tax_marks',
        'hide_empty' => false,
    ] );
    Timber::render('/blocks/base/header-search.twig',['marks'=>$marks,'search'=>$_GET['search']?$_GET['search']:'','brand'=>$_GET['brand']?$_GET['brand']:'']);
}

function footer_open(){

    Timber::render('/blocks/base/footer.twig',['phone'=>get_field('phone','options')]);
}


function wc_get_attribete($id,$attribute){
    $product = wc_get_product($id);

    return $product->get_attribute($attribute);

}

function wc_get_price($id){
    $product = wc_get_product($id);

    return $product->get_price();
}


function amount_price_in_cart(){
    return WC()->cart->get_cart_total();
}

function get_terms_ids($id,$term){
    $terms = get_the_terms( $id, $term );
    $str='';
    if($terms){
        foreach ($terms as $item){
            $str.=$item->term_id;
            if($item !== end($terms)) {
                $str.=',';
            }
        }
    }
    return $str;
}

add_action('pre_get_posts', 'codernote_pre_get_posts');
function codernote_pre_get_posts( $query ) {

    if ( $query->is_main_query() && !$query->is_feed() && !is_admin() ) {
        $query->set( 'pag',$query->query['paged']);
        $query->set( 'paged',get_query_var('page'));
    }
}



