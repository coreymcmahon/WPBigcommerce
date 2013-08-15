<?php
/*
Plugin Name: WP Bigcommerce
Plugin URI: http://www.coreymcmahon.com/
Description: TBA
Version: 1.0
Author: Corey McMahon
Author URI: http://www.coreymcmahon.com/
*/

require_once(dirname(__FILE__) . '/bootstrap.php');

define('WPBC_PLUGIN_IDENTIFIER', __FILE__);

add_shortcode( 'wpbigcommerce', array( 'WPBigcommerceProducts', 'shortcode' ) );

if (is_admin()) {
    add_action('admin_init', 'wp_bigcommerce_init');
    add_action('admin_menu', 'wp_bigcommerce_menu');
}

function wp_bigcommerce_menu() {
    // add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function)
    add_options_page('WP Bigcommerce', 'WP Bigcommerce', 'manage_options', WPBC_PLUGIN_IDENTIFIER, 'wp_bigcommerce_options_page'); // @TODO: menu_slug? should this be something else?
}

function wp_bigcommerce_init() {
    // register_setting( $option_group, $option_name, $sanitize_callback )
    register_setting('wp_bigcommerce_options', 'wp_bigcommerce_options');

    // add_settings_section( $id, $title, $callback, $page )
    add_settings_section('wp_bigcommerce_options_main', 'Store Settings', 'wp_bigcommerce_settings_section_main', WPBC_PLUGIN_IDENTIFIER);

    // add_settings_field( $id, $title, $callback, $page, $section, $args )
    add_settings_field('wp_bc_api_user',   'API Username', 'wp_bigcommerce_settings_field_api_user',   WPBC_PLUGIN_IDENTIFIER, 'wp_bigcommerce_options_main');
    add_settings_field('wp_bc_api_secret', 'API Secret',   'wp_bigcommerce_settings_field_api_secret', WPBC_PLUGIN_IDENTIFIER, 'wp_bigcommerce_options_main');
    add_settings_field('wp_bc_api_url',    'API URL',      'wp_bigcommerce_settings_field_api_url',    WPBC_PLUGIN_IDENTIFIER, 'wp_bigcommerce_options_main');
}

function wp_bigcommerce_settings_section_main() {
    /* add text in here */
}

function wp_bigcommerce_settings_field_api_user() {
    $options = get_option('wp_bigcommerce_options');
    echo "<input id='wp_bc_api_user' name='wp_bigcommerce_options[api_user]' size='40' type='text' value='" . $options['api_user'] . "' />";
}

function wp_bigcommerce_settings_field_api_secret() {
    $options = get_option('wp_bigcommerce_options');
    echo "<input id='wp_bc_api_secret' name='wp_bigcommerce_options[api_secret]' size='40' type='text' value='" . $options['api_secret'] . "' />";
}

function wp_bigcommerce_settings_field_api_url() {
    $options = get_option('wp_bigcommerce_options');
    echo "<input id='wp_bc_api_url' name='wp_bigcommerce_options[api_url]' size='40' type='text' value='" . $options['api_url'] . "' />";
}


function wp_bigcommerce_options_page() {
    if (!current_user_can('manage_options')) wp_die(__( 'You do not have sufficient permissions to access this page.' ));

    $view = new WPBigcommerceView('settings');
    echo $view->render();
}