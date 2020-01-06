<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 

/**
 * In acest fisier sunt prezente metode de securizare a site-ului
 */


add_filter( 'xmlrpc_methods', function( $methods ) {
   unset( $methods['pingback.ping'] );
   unset($methods['wp.getUsersBlogs']);
   return $methods;
} );
add_filter('xmlrpc_enabled','__return_false');
function remove_x_pingback($headers) {
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', 'remove_x_pingback');

# restrict dashboard
add_action( 'init', 'blockusers_init' );
function blockusers_init() {
	if ( is_admin() && ! current_user_can( 'manage_options' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_redirect( site_url() );
	exit;
	}
}

# Hide ACF
//add_filter('acf/settings/show_admin', '__return_false');