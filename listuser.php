<?php
/**
 * @package ListUser
 */
/*
Plugin Name: ListUser
Plugin URI: akdemy.net
Description: 
Author: quangnd
Author URI: akdemy.net
*/



// Action hook
require_once(plugin_dir_path(__FILE__) . '/class/ListUser.php');

$a = (new ListUser())->countUser();

$floor = false;

if ($a != 0) {
    $floor = true;
}

if($floor) {
    /* List User Register */
    function learnpress_add_custom_metabox() {
        add_meta_box(
            'custom-metabox',
            __( 'Danh sách đăng ký khóa học', 'learnpress' ),
            'learnpress_render_custom_metabox',
            'lp_course',
            'normal',
            'high'
        );
    }

    add_action( 'add_meta_boxes', 'learnpress_add_custom_metabox' );

    function learnpress_render_custom_metabox( $post ) {
        do_action( 'listuser', $post->ID );
    }
    /* List User Register */
}

// Active plugin
register_activation_hook( __FILE__, 'listUser_plugin_activation' );
function listUser_plugin_activation() {
}

// Deactive plugin
register_deactivation_hook( __FILE__, 'deactive_listUser_plugin_activation' );
function deactive_listUser_plugin_activation() {
    global $wpdb;
}