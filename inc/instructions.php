<?php

    ///////////////////////////////
    // Register Custom Post Type //
    ///////////////////////////////

    function inst_post_type_gen() {

        $labels = array(
            'name'                  => _x( 'Instructions', 'Post Type General Name', 'text_domain' ),
            'singular_name'         => _x( 'Instruction', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'             => __( 'Instructions', 'text_domain' ),
            'name_admin_bar'        => __( 'Instruction', 'text_domain' ),
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

    ////////////////////////////////////
    // Custom meta box on instructors //
    ////////////////////////////////////

    function custom_meta_box_info() {

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
          'id'             => 'instruction_meta_box',          // meta box id, unique per meta box
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
        $repeater_fields[] = $my_meta->addText($prefix.'re_text_field_id_selector',array('name'=> 'CSS element selector','desc'=> "Leve blank for a general pop-up."),true);
        $repeater_fields[] = $my_meta->addTextarea($prefix.'re_textarea_field_id',array('name'=> 'Instruction'),true);
        
        // Select field for placement
        $repeater_fields[] = $my_meta->addSelect( $prefix.'re_text_field_id_placement',
            array('top'=> 'Top', 'bottom'=> 'Bottom', 'right'=> 'Right', 'left'=> 'Left'),
            array('name'=> 'Placement', 'std'=> "top"),
            true
        );

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
    add_action( 'admin_init', 'custom_meta_box_info', 100 );

    //////////////////////////////////////////////////////
    // Add the instructors info on the admin page inner //
    //////////////////////////////////////////////////////

    function custom_add_inst_onto_page () {

        // Get the page current url
        $page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        // Get the part after wp-admin
        $page_url_after_wpadmin = explode( "wp-admin/", $page_url )[1];
        
        // Loop through all queries on the instructions
        $args = array(
            'post_type' => array( 'instruction' ),
        );

        // The Query
        $query = new WP_Query( $args );

        // The Loop
        $current_inst = NULL;
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();

                // Get the post meta
                $temp_post_meta = get_post_meta( get_the_id() );

                // If this matches the page
                if ( $page_url_after_wpadmin == $temp_post_meta["ba_target_page"][0] ) {

                    $current_inst = $temp_post_meta["ba_re_"];
                    break;

                }

            }
        }

        // Restore original Post Data
        wp_reset_postdata();

        // If we did not find any instructions for this page
        if ( is_null($current_inst) ) {
            return;
        }

        // Break this down into something js will understand
        $current_inst = json_encode(unserialize($current_inst[0]));

        // Save the variable for JS
        wp_enqueue_script('instruct_js', plugins_url() . '/wp-instruct/assets/instruct.js', array(), false, true);
        $translation_array = array(
            'instruct_string' => $current_inst,
        );
        wp_localize_script( 'instruct_js', 'instruct_object', $translation_array );

        // Enqueued script with localized data.
        wp_enqueue_script( 'instruct_js' );

    }
    add_action( 'admin_init', 'custom_add_inst_onto_page', 101 );