<?php
/*
Template Name: Главная
*/
/**
 * Header
 */
Timber::render('template-parts/blocks/base/head.twig');

/**
 * block Categories
 */
$marks =[
    'items'=>get_terms( [
        'taxonomy' => 'tax_marks',
        'hide_empty' => false,
        ] )];

Timber::render('template-parts/blocks/block-marks.twig',$marks);

/**
 * Блок почему с нами выгодно
 */

$benefits = [
    'title'=>get_field('benefits_title',$post->ID),
    'items'=>get_field('benefits',$post->ID),
];

Timber::render('template-parts/blocks/block-benefits.twig',$benefits);

/**
 * Нижний блок с сылками
 */
$bottom_links=[
    'left'=>get_field('bottom_links',$post->ID)['left'],
    'right'=>get_field('bottom_links',$post->ID)['right'],
];
Timber::render('template-parts/blocks/block-bottom_links.twig',$bottom_links);

/**
 * Footer
 */
footer_open();

