<?php
/*
 * Template Name: Оплата и доставка
 */
/**
 * Header
 */
Timber::render('template-parts/blocks/base/head.twig');
$main =[
    'conditions'=>[
        'shipping'=>get_field('conditions',$post->ID)['conditions_shipping'],
        'payment'=>get_field('conditions',$post->ID)['conditions_payment'],
    ],
    'content'=>get_field('content',$post->ID)
];
Timber::render('template-parts/payAndShipping/main.twig',$main);

$benefits = [
    'title'=>get_field('benefits_title',25),
    'items'=>get_field('benefits',25),
];

Timber::render('template-parts/blocks/block-benefits.twig',$benefits);
/**
 * Footer
 */
footer_open();