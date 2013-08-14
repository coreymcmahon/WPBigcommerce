<?php

class WPBigcommerceProductsTest extends PHPUnit_Framework_TestCase {

    private $request;
    private $products;

    public function testFetch()
    {
        $this->request = $this->getMockBuilder('WPBigcommerceHttpRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->request->expects($this->once())
            ->method('get')
            ->with('/products.json', array('limit' => 10, 'page' => 1,))
            ->will($this->returnValue(''));

        $this->products = new WPBigcommerceProducts($this->request);
        $this->products->fetch();
    }


}