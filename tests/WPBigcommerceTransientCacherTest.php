<?php

class WPBigcommerceTransientCacherTest extends PHPUnit_Framework_TestCase {

	private $wordpress;
	private $cacher;

	public function setUp()
	{
		$this->wordpress = Mockery::mock('WPBigcommerceWordpressFunctions');
		$this->cacher = new WPBigcommerceTransientCacher($this->wordpress);
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testHas()
	{
		$key = 'this is a key';
		$result = 'this is a result';

		$this->wordpress->shouldReceive('getTransient')
			->once()
			->with($key)
			->andReturn($result);

		$result = $this->cacher->has($key);
		$this->assertTrue($result);
	}

	public function testSet()
	{
		$key = 'this is a key';
		$value = 'this is a value';

		$this->wordpress->shouldReceive('setTransient')
			->once()
			->with($key, $value, WPBigcommerceTransientCacher::$DEFAULT_CACHE_PERIOD)
			->andReturn(true);

		$result = $this->cacher->set($key, $value);
		$this->assertTrue($result);
	}

	public function testGet()
	{
		$this->markTestIncomplete();
	}
}