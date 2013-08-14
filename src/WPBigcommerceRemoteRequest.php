<?php
/**
 * Class WPBigcommerceRemoteRequest
 *
 * Wrapper class for the wp_remote_request global function. Used to make dependency injection possible, improving test-
 * ability.
 *
 */
class WPBigcommerceRemoteRequest {

    public function remoteRequest($url, $args)
    {
        if (function_exists('wp_remote_request')) {
            return wp_remote_request($url, $args);
        } else {
            throw new Exception('Tried to execute function wp_remote_request without defining it first.');
        }
    }
}