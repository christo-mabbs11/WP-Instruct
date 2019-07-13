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
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'page',
            'menu_icon'             => 'dashicons-welcome-learn-more',
            'capability_type'     => array('cwm_instruction','cwm_instructions'),
            'map_meta_cap'        => true,
        );
        register_post_type( 'cwm_instruction', $args );

    }
    add_action( 'init', 'inst_post_type_gen', 0 );

    add_action('admin_init','cwm_inst_add_role_caps',999);
    function cwm_inst_add_role_caps() {
    
        // Add the roles you'd like to administer the custom post types
        $roles = array('administrator');
        
        // Loop through each role and assign capabilities
        foreach($roles as $the_role) { 
        
            $role = get_role($the_role);
        
                    $role->add_cap( 'read' );
                    $role->add_cap( 'read_cwm_instruction');
                    $role->add_cap( 'read_private_cwm_instructions' );
                    $role->add_cap( 'edit_cwm_instruction' );
                    $role->add_cap( 'edit_cwm_instructions' );
                    $role->add_cap( 'edit_others_cwm_instructions' );
                    $role->add_cap( 'edit_published_cwm_instructions' );
                    $role->add_cap( 'publish_cwm_instructions' );
                    $role->add_cap( 'delete_others_cwm_instructions' );
                    $role->add_cap( 'delete_private_cwm_instructions' );
                    $role->add_cap( 'delete_published_cwm_instructions' );
        
        }
    }

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
                'pages'          => array('cwm_instruction'),      // post types, accept custom post types as well, default is array('post'); optional
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
            global $menu, $submenu;

            // Build out menu of pages
            $be_pages = [];
            foreach ( $menu as $page ) {    // Top levels pages

                // Ignore empty page names
                if ( $page[0] && $page[2] && $page[0] != "" && $page[2] != "" ) {

                    // Remove content in the span tags
                    $tags = array("span");
                    $temp_page = preg_replace('#<(' . implode( '|', $tags) . ')(?:[^>]+)?>.*?</\1>#s', '', $page[0]);

                    $page_link = $page[2];
                    if ( strpos($page_link, '.php') === false ) {
                        $page_link = "admin.php/";
                    }

                    // Sub level pages
                    $temp_sub = $submenu[$page[2]];
                    foreach ( $temp_sub as $sub_page ) {    // Bottom levels pages

                        // Ignore empty page names
                        if ( $sub_page[0] && $sub_page[2] && $sub_page[0] != "" && $sub_page[2] != "" ) {

                            // Do not add the customise page
                            if ( $page[2] == "themes.php" && strpos($sub_page[2], 'customize.php') !== false ) {
                                continue;
                            }

                            // Remove content in the span tags
                            $tags = array("span");
                            $temp = preg_replace('#<(' . implode( '|', $tags) . ')(?:[^>]+)?>.*?</\1>#s', '', $sub_page[0]);

                            // Add some extra nice-ness
                            $temp = $temp_page . " > " . $temp;

                            $sub_link = $sub_page[2];
                            if ( strpos($sub_link, '.php') === false ) {
                                $sub_link = $page_link . "?page=" . $sub_link;
                            }
                            
                            // Save the value
                            $be_pages[$sub_link] = $temp;

                        }

                    }

                    // If this page is not set in it's children and this is not the default admin page
                    if ( !isset( $be_pages[$page_link] ) && $page_link != "admin.php/" ) {

                        // Add top level menu item
                        $be_pages[$page_link] = $temp_page;
                        
                    }

                }

            }

            // Debug
            // print_r( $menu );
            // print_r( $submenu );
            // print_r( $be_pages );
            // die();

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
            $repeater_fields[] = $my_meta->addText($prefix.'re_text_field_id_selector',array('name'=> 'CSS element selector'),true);
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

        // Get the full current url
        $current_url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        
        // Grab the compenents
        $current_url_parse = parse_url($current_url);
        $current_path = $current_url_parse["path"];
        if ( strpos($page_link, 'wp-admin/') === false ) {
            $current_path = explode( "wp-admin/", $current_path )[1];
        }
        $current_queries = explode( "&", $current_url_parse["query"] );

        // The Query
        $args = array(
            'post_type' => array( 'cwm_instruction' ),
        );
        $query = new WP_Query( $args );

        // The Loop
        $current_inst = NULL;
        if ( $query->have_posts() ) {

            while ( $query->have_posts() ) {
                
                $query->the_post();

                // Get the post meta
                $temp_post_meta = get_post_meta( get_the_id() );

                // Grab the compenents
                $temp_url_parse = parse_url($temp_post_meta['ba_target_page'][0]);
                $temp_path = $temp_url_parse["path"];
                if ( strpos($page_link, 'wp-admin/') === false ) {
                    $temp_path = explode( "wp-admin/", $temp_path )[1];
                }
                $temp_queries = explode( "&", $temp_url_parse["query"] );

                // If the paths match
                if ( $temp_path == $current_path ) {

                    // If all the queries of the temp url fit into the current one
                    if ( !array_diff($current_queries, $temp_queries) ) {

                        $current_inst = "okok";

                    }

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