<?php
/**
* Plugin Name: WP Instruct
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: Create easy to follow instructions for your users in the back-end.
* Version: 1.0
* Author: Chirstop Mabbs
* Author URI: https://github.com/christo-mabbs11
**/

define( 'INST__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Add in pliugin main functionality
require_once( INST__PLUGIN_DIR . 'inc/instructions.php' );