<?php
/*
 * Template Name: Контакты
 */

/**
 * Header
 */
Timber::render('template-parts/blocks/base/head.twig');
$main =[
    'city'=>get_field('city',$post->ID),
    'street'=>get_field('street',$post->ID),
    'email'=>get_field('email',$post->ID),
    'shedule'=>get_field('shedule',$post->ID),
    'phone_1'=>get_field('phone_1',$post->ID),
    'phone_2'=>get_field('phone_2',$post->ID),
    'map'=>get_field('map',$post->ID)
];
Timber::render('template-parts/contacts/main.twig',$main);

/**
 * Footer
 */
footer_open();