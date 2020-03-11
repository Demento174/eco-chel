<?php
/*
 * Template Name: Поиск
 */

$title ='';
$items = [];
$name='';
if(isset($_GET['search']) || isset($_GET['brand'])){
    $name =    $_GET['search'];
    $brand = $_GET['brand'];

    $title.='результаты поиска в каталоге сайта по запросу: <span style="color:green">"'.$name.'"</span>';

    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status'=> 'publish',
        'order'=> 'DESC',
        'orderby'=>'date',
        's'=> $name,
        'exact'=>false,
    ];
    if(!empty($brand) && $brand !== '0'){
        $title.=', Бренд: <span style="color:red">"'.$brand.'"</span>';
        $args['tax_query'] =[
            [
                'taxonomy' => 'tax_marks',
                'terms' => $brand,
                'field' => 'name',
                'include_children' => true,
                'operator' => 'IN'
            ]
        ];
    }

}else{
    $title='Страница поиска';
    $args = [
        'post_type' => 'product',
        'posts_per_page' => 20,
        'paged' => $page
    ];
}


if(get_posts($args)){

    $items = get_posts($args);
}else{
    $items = get_posts([
        'post_type' => 'product',
        'numberposts'=>-1,
        'posts_per_page' => 20,
        'include'=> wc_get_product_id_by_sku( $name ),
    ]);
}

$main = Timber::context();

$main['title']=$title;
$main['phone']=get_field('phone','options');
$main['products']=$items;
/**
 * Header
 */

Timber::render('template-parts/blocks/base/head.twig');

/**
 * Main
 */

Timber::render('template-parts/search/main.twig',$main);


/**
 * Footer
 */
footer_open();
