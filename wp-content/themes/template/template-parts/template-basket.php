<?php
/*
 * Template Name: Корзина
 */


/**
 * Header
 */
Timber::render('template-parts/blocks/base/head.twig');

/**
 * Main
 */
$args = [
    'post_type' => 'product',
    'posts_per_page' => 7,

];

$main = Timber::context();

$main['title']='ВАШ ЗАКАЗ';
$main['items']=WC()->cart->get_cart();


Timber::render('template-parts/basket/main.twig',$main);


/**
 * Footer
 */
footer_open();

