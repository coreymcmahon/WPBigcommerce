<?php

require_once(dirname(__FILE__) . '/../bootstrap.php');

class WPBigcommerceHttpRequestTest extends PHPUnit_Framework_TestCase {

    private $wpRemoteRequest;

    protected function setUp()
    {
        $this->wpRemoteRequest = $this->getMock('WPBigcommerceRemoteRequest', array('remoteRequest'));
    }

    public function testExecuteGetRequestSucceeds()
    {
        $domain = 'http://www.google.com';
        $url = '/';
        $htmlResponse = '<html/>';
        $request = new WPBigcommerceHttpRequest($domain, array(), $this->wpRemoteRequest);

        $this->wpRemoteRequest->expects($this->once())
            ->method('remoteRequest')
            ->with($domain . $url)
            ->will($this->returnValue(
                array(
                    'headers' => array(
                        'date' => 'Tue, 13 Aug 2013 07:57:26 GMT',
                        'expires' => '-1',
                        'cache-control' => 'private, max-age=0',
                        'content-type' => 'text/html; charset=ISO-8859-1',
                        'set-cookie' => array(),
                        'p3p' => 'CP="This is not a P3P policy! See http://www.google.com/support/accounts/bin/answer.py?hl=en&answer=151657 for more info."',
                        'server' => 'gws',
                        'x-xss-protection' => '1; mode=block',
                        'x-frame-options' => 'SAMEORIGIN',
                        'alternate-protocol' => '80:quic',
                    ),
                    'body' => $htmlResponse,
                    'response' => array('code' => 200, 'message' => 'OK'),
                    'cookies' => array(),
                    'filename' => null,
                )
            ));

        $this->assertEquals($request->get($url), $htmlResponse);
    }

    public function testUrlParametersCreatedSuccessfully()
    {
        $domain = 'http://www.google.com';
        $url = '/';
        $parameters = array('n' => 10, 'q' => 'some query');
        $request = new WPBigcommerceHttpRequest($domain, array(), $this->wpRemoteRequest);

        $this->wpRemoteRequest->expects($this->once())
            ->method('remoteRequest')
            ->with($domain . $url . '?n=10&q=some+query');

        $request->get($url, $parameters);
    }

    public function testAuthorisationHeaderAddedSuccessfully()
    {
        $username = 'admin';
        $password = 'aLDFk3r4e';
        $request = new WPBigcommerceHttpRequest('http://www.google.com', array(), $this->wpRemoteRequest);
        $request->auth($username, $password);

        $this->wpRemoteRequest->expects($this->once())
            ->method('remoteRequest')
            ->with('http://www.google.com/', array(
                'method'=> 'GET',
                'headers' => array(
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
                    'Content-Length' => 0
                ),
                'body' => '',
            ));

        $request->get('/');
    }

}