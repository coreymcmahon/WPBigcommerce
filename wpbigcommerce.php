<?php
/*
Plugin Name: WP Bigcommerce
Plugin URI: http://www.commercecoders.com/bigcommerce/wordpress-plugin
Description: WP Bigcommerce is the quickest and easiest way to list products from your Bigcommerce store on your Wordpress blog.
Version: 1.1
Author: Corey McMahon
Author URI: http://www.commercecoders.com/
*/

require_once(dirname(__FILE__) . '/bootstrap.php');

define('WPBC_PLUGIN_IDENTIFIER', md5(__FILE__));

define('WPBC_PLUGIN_PATH', plugins_url(str_replace(dirname(dirname(__FILE__)), '', dirname(__FILE__))));

add_shortcode( 'wpbigcommerce', array( 'WPBigcommerceProducts', 'shortcode' ) );

if (is_admin()) {
    add_action('admin_init', 'wp_bigcommerce_init');
    add_action('admin_menu', 'wp_bigcommerce_menu');
}

function wp_bigcommerce_menu() 
{
    // add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function)
    add_options_page('WP Bigcommerce', 'WP Bigcommerce', 'manage_options', WPBC_PLUGIN_IDENTIFIER, 'wp_bigcommerce_options_page');
}

function wp_bigcommerce_init() 
{
    // register_setting( $option_group, $option_name, $sanitize_callback )
    register_setting('wp_bigcommerce_options', 'wp_bigcommerce_options', 'wp_bigcommerce_options_validate');

    // add_settings_section( $id, $title, $callback, $page )
    add_settings_section('wp_bigcommerce_options_main', 'Store API Settings', 'wp_bigcommerce_settings_section_main', WPBC_PLUGIN_IDENTIFIER);

    // add_settings_field( $id, $title, $callback, $page, $section, $args )
    add_settings_field('wp_bc_api_status', 'Status',    'wp_bigcommerce_settings_field_api_status', WPBC_PLUGIN_IDENTIFIER, 'wp_bigcommerce_options_main');
    add_settings_field('wp_bc_api_user',   'Username',  'wp_bigcommerce_settings_field_api_user',   WPBC_PLUGIN_IDENTIFIER, 'wp_bigcommerce_options_main');
    add_settings_field('wp_bc_api_secret', 'Secret',    'wp_bigcommerce_settings_field_api_secret', WPBC_PLUGIN_IDENTIFIER, 'wp_bigcommerce_options_main');
    add_settings_field('wp_bc_api_url',    'Store URL', 'wp_bigcommerce_settings_field_api_url',    WPBC_PLUGIN_IDENTIFIER, 'wp_bigcommerce_options_main');
}

function wp_bigcommerce_options_validate($input)
{
    // convert to lower case to make string comparisons easier
    $apiUrl = strtolower($input['api_url']);
    
    // strip out the API endpoint info, this is handled inside the WPBigcommerceApi class
    $apiUrl = str_replace('/api/v2', '', $apiUrl);
    
    // make sure we're using HTTPS
    $apiUrl = str_replace('http://', 'https://', $apiUrl);
    if (strpos($apiUrl, 'https://') === false) $apiUrl = 'https://' . $apiUrl;

    // remove any trailing slash
    $apiUrl = rtrim($apiUrl, '/');

    return array(
        'api_user' => $input['api_user'],
        'api_secret' => $input['api_secret'],
        'api_url' => $apiUrl,
    );
}

function wp_bigcommerce_settings_section_main() 
{
    /* add text in here */
}

function wp_bigcommerce_settings_field_api_user() 
{
    $options = get_option('wp_bigcommerce_options');
    echo "<input id='wp_bc_api_user' name='wp_bigcommerce_options[api_user]' size='40' type='text' value='" . $options['api_user'] . "' placeholder='e.g.: admin' />";
}

function wp_bigcommerce_settings_field_api_secret() 
{
    $options = get_option('wp_bigcommerce_options');
    echo "<input id='wp_bc_api_secret' name='wp_bigcommerce_options[api_secret]' size='40' type='text' value='" . $options['api_secret'] . "' placeholder='e.g.: 912ec803b2ce49e4a541068d495ab570' />";
}

function wp_bigcommerce_settings_field_api_url() 
{
    $options = get_option('wp_bigcommerce_options');
    echo "<input id='wp_bc_api_url' name='wp_bigcommerce_options[api_url]' size='40' type='text' value='" . $options['api_url'] . "' placeholder='e.g.: https://www.mystore.com' />";
}

function wp_bigcommerce_settings_field_api_status() 
{
    $options = get_option('wp_bigcommerce_options');
    $apiUser = $options['api_user'];
    $apiSecret = $options['api_secret'];
    $apiUrl = $options['api_url'];

    if (empty($apiUser) || empty($apiSecret) || empty($apiUrl)) {
        echo '<p style="color: orange;">API details not provided. Please fill them in below.</p>';
    } else {
        $products = new WPBigcommerceProducts;
        if ($products->testConnection()) {
            echo '<span style="color: green;">Successfully connected to the Bigcommerce API.</span>';
        } else {
            echo '<span style="color: red;">Could not connect to Bigcommerce API. Please check the settings below.</span>';
        }
    }
}

function wp_bigcommerce_options_page() 
{
    if (!current_user_can('manage_options')) wp_die(__( 'You do not have sufficient permissions to access this page.' ));
    $view = new WPBigcommerceView('settings');
    echo $view->render();
}

// 
add_action( 'wp_enqueue_scripts', 'wp_bigcommerce_enqueue_assets' );
function wp_bigcommerce_enqueue_assets() 
{
    wp_enqueue_style('wp_bigcommerce_style_css', WPBC_PLUGIN_PATH.'/assets/css/styles.css');
}

// include presstrend analytics
require_once(dirname(__FILE__) . '/presstrends.php');
