<?php

require_once(dirname(__FILE__) . '/../bootstrap.php');

class WPBigcommerceProducts
{
    public static $DEFAULT_CACHE_PERIOD = 86400;

    public static $PRODUCTS_TRANSIENT_KEY = 'wp_bigcommerce_products';
    public static $CATEGORIES_TRANSIENT_KEY = 'wp_bigcommerce_categories';

    /** @var \WpBigcommerceHttpRequest */
    private $request;
    private $limit;
    private $page;
    private $wordpress;

    /**
     * @param WpBigcommerceHttpRequest $request
     * @param null $page
     * @param null $limit
     */
    public function __construct($request, $page = null, $limit = null, $wordpress = null)
    {
        $this->request = $request;
        $this->page  = ($page  !== null) ? $page  : 1;
        $this->limit = ($limit !== null) ? $limit : 250;
        $this->wordpress = ($wordpress !== null) ? $wordpress : new WPBigcommerceWordpressFunctions();
    }

    public function testConnection()
    {
        $time = $this->request->get('/api/v2/time.json');
        return $time !== null;
    }

    public function fetchProducts()
    {
        if (($transient = $this->wordpress->getTransient(self::$PRODUCTS_TRANSIENT_KEY)) !== false) return $this->parseResponse($transient);

        $products = $this->request->get('/api/v2/products.json', array('page' => $this->page, 'limit' => $this->limit));

        $this->wordpress->setTransient(self::$PRODUCTS_TRANSIENT_KEY, $products, self::$DEFAULT_CACHE_PERIOD);

        return $this->parseResponse($products);

    }

    private function parseResponse($response)
    {
        $json = new Services_JSON();
        return $json->decode($response);
    }

    // @TODO: change this lameness
    public static function shortcode()
    {
        $options = get_option('wp_bigcommerce_options');
        //$request = new WPBigcommerceHttpRequest('https://store-3hdjd3.mybigcommerce.com');
        //$request->auth('admin', '1efd11a7e371c75aaebab73d65ce5ef285b98d0b');

        $request = new WPBigcommerceHttpRequest($options['api_url']);
        $request->auth($options['api_user'], $options['api_secret']);

        $products = new self($request);

        foreach ($products->fetchProducts() as $product) {
            $view = new WPBigcommerceView('product', array('product' => $product));
            echo $view->render();
        }
    }
}