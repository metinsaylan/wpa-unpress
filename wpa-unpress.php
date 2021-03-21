<?php 
/*
* Plugin Name: WPA Unpress
* Plugin URI: https://wpassist.me/plugins/wpa-unpress/
* Description: Clears all WordPress default head items.
* Version: 1.1
* Author: Metin Saylan
* Author URI: https://metinsaylan.com/
*/

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'template_redirect', 'rest_output_link_header' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

add_filter( 'show_admin_bar', '__return_false' );
add_filter( 'pre_comment_content', 'esc_html' );

add_filter( 'the_generator', 'wpa_unpress_remove_version' );
function wpa_unpress_remove_version() {
  return '';
}

add_filter( 'script_loader_src', 'wpa_unpress_cleanup_query_string', 15, 1 ); 
add_filter( 'style_loader_src', 'wpa_unpress_cleanup_query_string', 15, 1 );
function wpa_unpress_cleanup_query_string( $src ){

  if( strpos( $src, 'fonts.googleapis.com' ) !== false || strpos( $src, '?' ) === false ){
    return $src;
  }

  $parts = explode( '?', $src ); 
  return $parts[0];

}


add_filter( 'login_errors', 'wpa_unpress_prevent_login_error' );
function wpa_unpress_prevent_login_error(){
  return 'Huh?';
}


add_action( 'wp_enqueue_scripts', 'wpa_unpress_cleanup_scripts_styles' );
function wpa_unpress_cleanup_scripts_styles(){
  wp_dequeue_style( 'wp-block-library' );
	wp_deregister_script( 'wp-embed' );
}

