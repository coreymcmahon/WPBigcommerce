<?php

class WPBigcommerceProductsTest extends PHPUnit_Framework_TestCase {

    private $api;
    private $cacher;
    private $wordpress;

    public function setUp()
    {
        $this->api = Mockery::mock('WPBigcommerceApi');
        $this->cacher = Mockery::mock('WPBigcommerceTransientCacher');
        $this->wordpress = Mockery::mock('WPBigcommerceWordpressFunctions');
        $this->products = new WPBigcommerceProducts($this->api, $this->cacher, $this->wordpress);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testTestConnection()
    {
        $this->api->shouldReceive('testConnection')
            ->once()
            ->andReturn(true);
        $this->assertTrue($this->products->testConnection());
    }

    public function testDumpTransients()
    {
        $cachedProductIds = array(1,5,7,8);
        $cachedCategoryIds = array(3,7);

        $this->cacher->shouldReceive('get')->with('wp_bigcommerce_products')->once()->andReturn(implode(',', $cachedProductIds).',');
        $this->cacher->shouldReceive('get')->with('wp_bigcommerce_product_images')->once()->andReturn(implode(',', $cachedProductIds).',');
        $this->cacher->shouldReceive('get')->with('wp_bigcommerce_categories')->once()->andReturn(implode(',', $cachedCategoryIds).',');

        foreach ($cachedProductIds as $id) {
            $this->cacher->shouldReceive('clear')->with("wp_bigcommerce_products_{$id}")->once()->andReturn(true);
            $this->cacher->shouldReceive('clear')->with("wp_bigcommerce_product_images_{$id}")->once()->andReturn(true);
        }
        foreach ($cachedCategoryIds as $id) {
            $this->cacher->shouldReceive('clear')->with("wp_bigcommerce_categories_{$id}")->once()->andReturn(true);
        }

        $this->cacher->shouldReceive('clear')->with('wp_bigcommerce_products')->once()->andReturn(true);
        $this->cacher->shouldReceive('clear')->with('wp_bigcommerce_product_images')->once()->andReturn(true);
        $this->cacher->shouldReceive('clear')->with('wp_bigcommerce_categories')->once()->andReturn(true);

        $this->products->dumpTransients();
    }

    public function testGetItemFromCache()
    {
        $key = 'wp_bigcommerce_products';
        $id = 44;
        $result = 'this is the result';
        $this->cacher->shouldReceive('get')->with('wp_bigcommerce_products_44', '')->once()->andReturn($result);
        
        $this->assertEquals($result, $this->products->getItemFromCache($key, $id));
    }

    public function testAddItemToCache()
    {
        $key = 'wp_bigcommerce_products';
        $id = 45;
        $result = 'this is the result';
        $this->cacher->shouldReceive('set')->with('wp_bigcommerce_products_45', $result)->once()->andReturn(true);
        $this->cacher->shouldReceive('get')->with('wp_bigcommerce_products', '')->once()->andReturn('40,41,42,');
        $this->cacher->shouldReceive('set')->with('wp_bigcommerce_products', '40,41,42,45,')->once()->andReturn(true);

        $this->assertTrue($this->products->addItemToCache($key, $id, $result));
    }

    public function testFindProduct()
    {
        $this->markTestIncomplete();
    }

    public function testFindCategory()
    {
        $this->markTestIncomplete();
    }

    public function testFindProductImage()
    {
        $this->markTestIncomplete();
    }

    public function testShortcode()
    {
        $this->markTestIncomplete();
    }
}