<?php
/*
 * Template Name: Каталог
 */


$page = get_query_var('pag')?get_query_var('pag'):1;

if(get_queried_object()->taxonomy == 'product_cat' || get_queried_object()->taxonomy == 'tax_marks')
{

    $args = [
        'post_type' => 'product',
        'posts_per_page' => 20,
        'paged' =>  $page,
        'numberposts'=>-1,
        'tax_query'             => array(
            array(
                'taxonomy'      => get_queried_object()->taxonomy,
                'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                'terms'         => get_queried_object()->term_id,
                'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
            ),
        )
    ];
}
else
{

    $args = [
        'post_type' => 'product',
        'numberposts'=>-1,
        'posts_per_page' => 20,
        'paged' => $page
    ];
}

$main = Timber::context();

$main['title']='Автозапчасти';
$main['phone']=get_field('phone','options');
$main['marks']=get_terms( ['taxonomy' => 'tax_marks'] );
$main['catalogs']=get_terms( ['taxonomy' => 'product_cat'] );
$main['products']=new Timber\PostQuery($args);
$main['taxonomy']=get_queried_object()->taxonomy == 'tax_marks';

/**
 * Header
 */

Timber::render('template-parts/blocks/base/head.twig');

/**
 * Main
 */

Timber::render('template-parts/catalog/main.twig',$main);


/**
 * Footer
 */
footer_open();

