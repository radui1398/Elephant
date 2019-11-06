<?php
defined('ABSPATH') or die('Direct access is forbidden!');

/**
 * Fisiere necesare pentru a rula tema.
 */
# Functions Controller
require_once TEMPLATEPATH . '/controllers/Theme.php';
# Register Enqueue
require_once TEMPLATEPATH . '/controllers/Enqueue.php';
# Register navigation menus
require_once TEMPLATEPATH . '/controllers/Menu.php';
# Register ACF Controller - INACTIV
# require_once TEMPLATEPATH . '/controllers/Scorpio.php';
# Register Repeater
require_once TEMPLATEPATH . '/controllers/Repeater.php';
# Register Gallery
require_once TEMPLATEPATH . '/controllers/Gallery.php';
# Register Post Type
require_once TEMPLATEPATH . '/framework/post-types.php';
# Theme security
require_once TEMPLATEPATH . '/framework/security.php';
# Util Functions
require_once TEMPLATEPATH . '/framework/util.php';
# Shortcodes
require_once TEMPLATEPATH . '/framework/shortcodes.php';
# Widgets
require_once TEMPLATEPATH . '/framework/widgets.php';


/**
 * Necesar pentru folosirea sesiunilor.
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Optiuni Extra:
 */
define('THEME_TEXT_DOMAIN', 'theme_slug');
define('THEME_DIR', get_template_directory_uri());
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_action( 'init', 'disable_emojis' );
add_filter('upload_mimes', 'cc_mime_types');







