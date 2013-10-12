<?php

class WPBigcommerceTransientCacher {

	public static $DEFAULT_CACHE_PERIOD = 0; // default = doesn't expire
	protected $wordpress;

	public function __construct($wordpress = null)
	{
		if ($wordpress === null) $wordpress = new WPBigcommerceWordpressFunctions();
		$this->wordpress = $wordpress;
	}

	public function has($key)
	{
		return ($this->get($key) !== null);
	}

	public function get($key, $default = null)
	{
		if (($value = $this->wordpress->getTransient($key)) !== null) return $value;
		return $default;
	}

	public function set($key, $value, $period = null)
	{
		if ($period === null) $period = self::$DEFAULT_CACHE_PERIOD;

		return $this->wordpress->setTransient($key, $value, $period);
	}

	public function clear($key)
	{
		return $this->wordpress->deleteTransient($key);
	}
}