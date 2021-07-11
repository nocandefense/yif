<?php
/**
 * Plugin Name:     Performant iframe
 * Plugin URI:      brockcallahan.com/performant-iframe
 * Description:     Replace an image with iframe when clicked.
 * Author:          Brock Callahan
 * Author URI:      https://brockcallahan.com
 * Text Domain:     performance-iframe
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         performant_iframe
 */

function p_iframe_fun( $atts ) {
	 $iframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	 $defaults = array(
		  'thumb' => 'https://img.youtube.com/vi/<insert-youtube-video-id-here>/0.jpg',
		  'link' => '',
		  'id' => 'a3Z7zEc7AXQ',
		  'width' => '560',
		  'height' => '315',
		  'play_button' => plugin_dir_url( __FILE__ ) . 'youtube-png-picture-180x180.png',
		  'play_button_size' => '',
		  'play_button_height' => '150px',
		  'play_button_width' => '150px',
		  'rounded' => '',
		  'border-radius' => '',
          'class_list' => 'p-iframe-wrap',
		  );
	 extract( shortcode_atts( $defaults, $atts ) );

	 if ( preg_match( '/x/', $play_button_size ) ) {
		  $btn_sizes = explode( 'x', $btn_sizes );
		  if ( is_numeric( $btn_sizes[0] ) && is_numeric( $btn_sizes[1] ) ) {
			   $play_button_height = $btn_sizes[0];
			   $play_button_width = $btn_sizes[1];
		  }
	 }
    
	 if ( $link != '' ) {
		  $id = substr( $link, strpos( $link, '=' ) + 1 );
	 }
    
	 $thumb = substr_replace( $thumb, $id, strpos( $thumb, '<insert-youtube-video-id-here>' ), strlen('<insert-youtube-video-id-here>') );
    
	 if ( preg_match('/embed\/\?autoplay=1/i', $iframe ) ) {
		  $iframe = substr_replace( $iframe, $id, strpos( $iframe, '?autoplay=1' ), 0 );
	 }

     if ( $rounded !== '' ) {
         $class_list .= ' rounded';
     }
    
	 return "<figure class='{$class_list}' style='width:{$width};height:{$height};' data-attribute='{$iframe}'><img class='p-iframe-thumb' src={$thumb} width='100%' height='100%'/><img class='p-iframe-play-btn' src='{$play_button}' style='width:${play_button_width};height=${play_button_size}' /></figure>";
}
add_shortcode( 'p_iframe', 'p_iframe_fun' );

/* enqueue javascript files */
function p_iframe_enqueue() {
	 wp_enqueue_style( 'p-iframe-css', plugin_dir_url( __FILE__ ) . 'performant-iframe.css', false, 'v4' );
	 wp_enqueue_script(
		  'p-iframe',
		  plugin_dir_url( __FILE__ ) . 'performant-iframe.js',
		  array( 'jquery' ),
		  'v4',
		  true
		  );
}
add_action( 'wp_enqueue_scripts', 'p_iframe_enqueue' );
