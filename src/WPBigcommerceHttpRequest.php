<?php

require_once(dirname(__FILE__) . '/../bootstrap.php');

class WPBigcommerceHttpRequest {

    const DEFAULT_ACCEPT       = 'application/json';
    const DEFAULT_CONTENT_TYPE = 'application/json';

    private $domain;
    private $headers;
    private $remoteRequest;

    /**
     * @param $domain
     * @param array $headers
     * @param null $remoteRequest
     */
    public function __construct($domain, $headers = array(), $remoteRequest = null)
    {
        $this->domain = $domain;
        $this->headers = $headers;
        $this->remoteRequest = ($remoteRequest !== null) ? $remoteRequest : new WPBigcommerceRemoteRequest();

        if (!isset($this->headers['Accept'])) $this->headers['Accept'] = self::DEFAULT_ACCEPT;
        if (!isset($this->headers['Content-Type'])) $this->headers['Content-Type'] = self::DEFAULT_CONTENT_TYPE;
    }

    /**
     * @param $username
     * @param $password
     */
    public function auth($username, $password)
    {
        $this->headers['Authorization'] = 'Basic ' . base64_encode($username . ':' . $password);
    }

    /**
     * @param $url
     * @param array $parameters
     * @return mixed
     */
    public function get($url, $parameters = array())
    {
        if (count($parameters) > 0) {
            $urlparameters = array();
            foreach ($parameters as $key => $value) {
                // url encode each of the parameters
                $urlparameters[] = urlencode($key) . '=' . urlencode($parameters[$key]);
            }

            // create and append the query string to the URL
            $urlparameters = implode('&', $urlparameters);
            $url = (strpos($url, '?') !== -1) ? $url . '?' : $url;
            $url .= $urlparameters;
        }

        return $this->execute($url, 'GET');
    }

    /**
     * @param $url
     * @param $method
     * @param string $body
     * @return mixed
     */
    private function execute($url, $method, $body = '')
    {
        $jsonBody = $body === '' ? '' : toJSON($body);
        $this->headers['Content-Length'] = strlen($jsonBody);

        // Setup variable for wp_remote_post
        $request = array(
            'method'    => $method,
            'headers'   => $this->headers,
            'body'      => $jsonBody
        );

        $response = $this->remoteRequest->remoteRequest($this->domain . $url, $request);

        if ($response['response']['code'] != '200') return null;

        return $response['body'];
    }
}