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
        'width' => '560px',
        'height' => '315px',
        'size' => '',
        'play_button' => plugin_dir_url( __FILE__ ) . '/icons/youtube-play-1.png',
        'play_button_size' => '',
        'play_button_height' => '150px',
        'play_button_width' => '150px',
        'rounded' => '',
        'border-radius' => '',
        'class_list' => 'p-iframe-wrap',
        't' => '',
        'time' => '',
        'yt_mins' => '',
        'secs' => '',
        'timestamp' => '',
        'thumb_quality' => '',
        'controls' => true,
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

    /* figure sizes */
    if ( $sizes = preg_split('/x/i', $size ) ) {
        $sizes = explode( 'x', $size );
        if ( is_numeric( $sizes[0] ) && is_numeric( $sizes[1] ) ) {
            $width = $sizes[0] . 'px';
            $height = $sizes[1] . 'px';
        }
    } elseif ( preg_match( '/\//i', $size ) ) {
        $sizes = explode( '/', $size );
        $width = $sizes[0] . 'px';
        $height = $sizes[1] . 'px';
    }

    /* YouTube time */
    if ( $time !== '' ) {
        $yt_mins = jbc_parse_yt_time_qstr_mins( $time );
        $secs = jbc_parse_yt_time_qstr_secs( $time );
        $yt_mins_to_secs = jbc_mins_to_secs( $yt_mins );
        $secs = (int) $secs + (int) $yt_mins_to_secs;
        $iframe = str_replace( 'autoplay=1', "autoplay=1&start={$secs}", $iframe );
    } elseif ( $secs !== '' || $yt_mins !== '' ) {
        if ( $yt_mins == '' ) {
            $iframe = substr_replace( $iframe, "&t={$secs}s", strpos( $iframe, '?autoplay=1' ), 0 );
        } elseif ( $secs == '') {
            $iframe = substr_replace( $iframe, "&t={$yt_mins}m", strpos( $iframe, '?autoplay=1' ), 0 );
        } else {
            $iframe = substr_replace( $iframe, "&t={$yt_mins}m{$secs}s", strpos( $iframe, '?autoplay=1' ), 0 );
        }
    }

    if ( ! $controls ) {
        /* get last slash */
    }
    
    return "<figure class='{$class_list}' style='width:{$width};height:{$height};' data-attribute='{$iframe}'><img class='p-iframe-thumb' src={$thumb} width='100%' height='100%'><div class='p-iframe-play-btn dashicons dashicons-youtube'></div></figure>";
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

/* utility functions */
function jbc_parse_yt_time_qstr_secs( $t ) {
    $secs = substr( $t, strpos($t, 'm') + 1 );
    return substr_replace($secs, '', -1);
}

function jbc_parse_yt_time_qstr_mins( $t ) {
    return (int) substr_replace( $t, "", strpos($t, 'm') );
}

function jbc_mins_to_secs( $m ) {
    return (int) $m * 60;
}
