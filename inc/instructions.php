<?php

    // Register Custom Post Type
    function inst_post_type_gen() {

        $labels = array(
            'name'                  => _x( 'Instructions', 'Post Type General Name', 'text_domain' ),
            'singular_name'         => _x( 'Instruction', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'             => __( 'Instruction Types', 'text_domain' ),
            'name_admin_bar'        => __( 'Instruction Type', 'text_domain' ),
            'archives'              => __( 'Item Archives', 'text_domain' ),
            'attributes'            => __( 'Item Attributes', 'text_domain' ),
            'parent_item_colon'     => __( 'Parent Instruction:', 'text_domain' ),
            'all_items'             => __( 'All Instructions', 'text_domain' ),
            'add_new_item'          => __( 'Add New Instruction', 'text_domain' ),
            'add_new'               => __( 'Add New', 'text_domain' ),
            'new_item'              => __( 'New Instruction', 'text_domain' ),
            'edit_item'             => __( 'Edit Instruction', 'text_domain' ),
            'update_item'           => __( 'Update Instruction', 'text_domain' ),
            'view_item'             => __( 'View Instruction', 'text_domain' ),
            'view_items'            => __( 'View Instructions', 'text_domain' ),
            'search_items'          => __( 'Search Instruction', 'text_domain' ),
            'not_found'             => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
            'featured_image'        => __( 'Featured Image', 'text_domain' ),
            'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
            'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
            'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
            'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
            'items_list'            => __( 'Items list', 'text_domain' ),
            'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
            'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
        );
        $args = array(
            'label'                 => __( 'Instruction', 'text_domain' ),
            'description'           => __( 'Post Type Description', 'text_domain' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'instruction', $args );

    }
    add_action( 'init', 'inst_post_type_gen', 0 );