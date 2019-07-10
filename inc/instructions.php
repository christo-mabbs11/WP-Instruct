<?php

    ///////////////////////////////
    // Register Custom Post Type //
    ///////////////////////////////

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
            'supports'              => array( 'title' ),
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
            'menu_icon'             => 'dashicons-welcome-learn-more',
        );
        register_post_type( 'instruction', $args );

    }
    add_action( 'init', 'inst_post_type_gen', 0 );

    /////////////////////
    // Custom meta box //
    /////////////////////

    function get_admin_menus() {

        if (is_admin()){
        
        /* 
         * prefix of meta keys, optional
         * use underscore (_) at the beginning to make keys hidden, for example $prefix = '_ba_';
         *  you also can make prefix empty to disable it
         * 
         */
        $prefix = 'ba_';
        
        /* 
         * configure your meta box
         */
        $config = array(
          'id'             => 'demo_meta_box',          // meta box id, unique per meta box
          'title'          => 'Page Instructions',          // meta box title
          'pages'          => array('instruction'),      // post types, accept custom post types as well, default is array('post'); optional
          'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
          'priority'       => 'high',            // order of meta box: high (default), low; optional
          'fields'         => array(),            // list of meta fields (can be added by field arrays)
          'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
          'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
        );
        
        /*
         * Initiate your meta box
         */
        $my_meta =  new AT_Meta_Box($config);
        
        /*
         * Add fields to your meta box
         */

        // Create the page selector array
        global $menu, $submenu, $pagenow;

        // Build out menu of pages
        $be_pages = [];
        foreach ( $menu as $page ) {    // Top levels pages

            // Ignore empty page names
            if ( $page[0] && $page[2] && $page[0] != "" && $page[2] != "" ) {

                // Remove content in the span tags
                $tags = array("span");
                $temp_page = preg_replace('#<(' . implode( '|', $tags) . ')(?:[^>]+)?>.*?</\1>#s', '', $page[0]);

                // Sub level pages
                $temp_sub = $submenu[$page[2]];
                foreach ( $temp_sub as $sub_page ) {    // Top levels pages

                    // Ignore empty page names
                    if ( $sub_page[0] && $sub_page[2] && $sub_page[0] != "" && $sub_page[2] != "" ) {

                        // Remove content in the span tags
                        $tags = array("span");
                        $temp = preg_replace('#<(' . implode( '|', $tags) . ')(?:[^>]+)?>.*?</\1>#s', '', $sub_page[0]);
                        if ( $temp == "Add New" ) {
                            $temp = "Inner/Add New";
                        }
                        $temp = $temp_page . " > " . $temp;
                        
                        // Save the value
                        $be_pages[$sub_page[2]] = $temp;

                    }

                }

            }

        }

        // Select field
        $my_meta->addSelect( $prefix.'target_page',
            
            $be_pages,

            array('name'=> 'Instruction Page', 'std'=> array($be_pages[0]))

        );

        /*
         * To Create a reapeater Block first create an array of fields
         * use the same functions as above but add true as a last param
         */
        $repeater_fields[] = $my_meta->addText($prefix.'re_text_field_id_name',array('name'=> 'Instruction','desc'=> "Give this instruction a title."),true);
        $repeater_fields[] = $my_meta->addText($prefix.'re_text_field_id_selector',array('name'=> 'jQuery element selector','desc'=> "Leve blank for a general pop-up."),true);
        $repeater_fields[] = $my_meta->addTextarea($prefix.'re_textarea_field_id',array('name'=> 'Instruction'),true);
        /*
         * Then just add the fields to the repeater block
         */
        //repeater block
        $my_meta->addRepeaterBlock($prefix.'re_',array(
          'inline'   => true, 
          'name'     => 'Instructions List',
          'fields'   => $repeater_fields, 
          'sortable' => true
        ));
        
        //Finish Meta Box Declaration 
        $my_meta->Finish();
      }

    }
    add_action( 'admin_menu', 'get_admin_menus' );