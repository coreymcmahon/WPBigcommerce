<?php 

/**
 * Provides a wrapper around Wordpress functions so we aren't calling them
 * directly.
 */
class WPBigcommerceWordpressFunctions {
	
	public function setTransient($transient, $value, $expiration)
	{
		if (function_exists('set_transient')) {
			return set_transient($transient);
		}
		throw new BadFunctionCallException('function set_transient does not exist.');
	}

	public function getTransient($transient)
	{
		if (function_exists('get_transient')) {
			return get_transient($transient);
		}
		throw new BadFunctionCallException('function get_transient does not exist.');
	}

	public function getOption($option, $default = null)
	{
		if (function_exists('get_option')) {
			return get_option($option, $default);
		}
		throw new BadFunctionCallException('function get_option does not exist.');
	}

	public function wpRemoteRequest($url, $args = null)
	{
		if (function_exists('wp_remote_request')) {
			return wp_remote_request($url, $args);
		}
		throw new BadFunctionCallException('function wp_remote_request does not exist.');
	}
}