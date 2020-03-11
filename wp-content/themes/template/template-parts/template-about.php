<?php
/*
Template Name: О компании
*/
/**
 * Header
 */
Timber::render('template-parts/blocks/base/head.twig');
$main =[
    'content'=>get_field('content',$post->ID)
];
Timber::render('template-parts/about/main.twig',$main);

$benefits = [
    'title'=>get_field('benefits_title',25),
    'items'=>get_field('benefits',25),
];

Timber::render('template-parts/blocks/block-benefits.twig',$benefits);
/**
 * Footer
 */
footer_open();