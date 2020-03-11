<?php
$product = wc_get_product($post->ID);
/**
 * Header
 */
Timber::render('template-parts/blocks/base/head.twig');

$product_cart = [
    'id'=>$product->get_id(),
	'title'=>$product->get_title(),
	'catalog_number'=>$product->get_sku(),
	'in_stock'=>$product->get_attribute('pa_на-складе'),
	'marks'=>get_terms_title(get_the_terms($post->ID, 'tax_marks' )),
	'categories'=>get_terms_title(get_the_terms($post->ID, 'product_cat' )),
	'price'=>$product->get_price_html(),
	'phone'=>get_field('phone','options'),
	'conditions'=>[
		'shipping'=>get_field('conditions','options')['conditions_shipping'],
		'payment'=>get_field('conditions','options')['conditions_payment'],
	],
];




/**
 * Main
 */
Timber::render('template-parts/product-cart/main.twig',$product_cart);

/**
 * Footer
 */
footer_open();