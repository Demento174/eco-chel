<?php


namespace CustomPosts;


class CustomPostsRegister extends  CustomPosts
{
    function __construct($slug,$label,$args)
    {
        $this->setSlug($slug);
        $this->setLabels($label);
        $this->setArgs($args);

        add_action('init', [$this,'register_posts_types']);
    }


    public function register_posts_types(){

        $labels = array(
            'name' => _x( $this->labels['name'], $this->slug ),
            'singular_name' => _x( $this->labels['singular_name'], $this->slug ),
            'add_new' => _x( $this->labels['add_new'], $this->slug ),
            'add_new_item' => _x( $this->labels['add_new_item'], $this->slug ),
            'edit_item' => _x( $this->labels['edit_item'], $this->slug ),
            'new_item' => _x( $this->labels['new_item'], $this->slug ),
            'view_item' => _x( $this->labels['view_item'], $this->slug ),
            'search_items' => _x( $this->labels['search_items'], $this->slug ),
            'not_found' => _x( $this->labels['not_found'], $this->slug ),
            'not_found_in_trash' => _x( $this->labels['not_found_in_trash'], $this->slug ),
            'parent_item_colon' => _x( $this->labels['parent_item_colon'], $this->slug ),
            'menu_name' => _x( $this->labels['menu_name'], $this->slug ),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => $this->args['hierarchical'],
            'supports' => $this->args['supports'],
            'public' => $this->args['public'],
            'map_meta_cap' => $this->args['map_meta_cap'],
            'show_ui' => $this->args['show_ui'],
            'menu_position'=>$this->args['menu_position'],
            'menu_icon' => $this->args['menu_icon'],
            'show_in_nav_menus' => $this->args['show_in_nav_menus'],
            'publicly_queryable' => $this->args['publicly_queryable'],
            'exclude_from_search' => $this->args['exclude_from_search'],
            'query_var' => $this->args['query_var'],
            'can_export' => $this->args['can_export'],
            'rewrite' => $this->args['rewrite'],
            'capability_type' => $this->args['capability_type'],
            'has_archive' => $this->args['has_archive'],
        );

        register_post_type( $this->slug, $args );
    }
}