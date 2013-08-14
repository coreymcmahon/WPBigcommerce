<?php
/*
Plugin Name: WP Bigcommerce
Plugin URI: http://www.coreymcmahon.com/
Description: TBA PHP 5.3 min, Curl required
Version: 1.0
Author: Corey McMahon
Author URI: http://www.coreymcmahon.com/
*/

require_once(dirname(__FILE__) . '/bootstrap.php');

add_shortcode( 'wpbigcommerce', array( 'WPBigcommerceProducts', 'shortcode' ) );

add_action('admin_menu', 'wp_bigcommerce_menu' );

function wp_bigcommerce_menu() {
    add_options_page('WP Bigcommerce', 'WP Bigcommerce', 'manage_options', __FILE__, 'wp_bigcommerce_options'); // @TODO: menu_slug? should this be something else?
}

function wp_bigcommerce_options() {
    if (!current_user_can('manage_options')) wp_die(__( 'You do not have sufficient permissions to access this page.' ));

    $data = array(
        'action' => $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'],
    );
    $view = new WPBigcommerceView('settings', $data);
    echo $view->render();
}