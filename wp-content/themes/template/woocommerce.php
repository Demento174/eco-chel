<?
/*-------------------------------[ START ]-------------------------------*/
echo '<pre>';
var_dump('wooconnerce');
die;
/*-------------------------------[ END ]-------------------------------*/
if($post->post_type=='product' && !is_archive()){
	get_template_part('template-parts/post_type/product');
}
if(is_archive()){
	get_template_part('template-parts/archive-product');
}