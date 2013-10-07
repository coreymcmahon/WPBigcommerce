<?php

require_once(dirname(__FILE__) . '/../bootstrap.php');

class WPBigcommerceProducts
{
    public static $DEFAULT_CACHE_PERIOD = 86400;

    public static $PRODUCTS_TRANSIENT_KEY = 'wp_bigcommerce_products';
    public static $PRODUCT_IMAGES_TRANSIENT_KEY = 'wp_bigcommerce_product_images';
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

    public static function getFields()
    {
        return array(
            'image',
            'name',
            'sku',
            'description',
            'price',
            'condition',
            'warranty',
            'inventory',
            'weight',
            'width',
            'height',
            'depth',
            'rating',
            'rating-total',
            'rating-count',
            'brand',
            'categories',
         );
    }

    public static function getFieldsString()
    {
        return implode(',', self::getFields());
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

    public function fetchCategories()
    {
        if (($transient = $this->wordpress->getTransient(self::$CATEGORIES_TRANSIENT_KEY)) !== false) return $this->parseResponse($transient);

        $categories = $this->request->get('/api/v2/categories.json', array('page' => $this->page, 'limit' => $this->limit));

        $this->wordpress->setTransient(self::$CATEGORIES_TRANSIENT_KEY, $categories, self::$DEFAULT_CACHE_PERIOD);

        return $this->parseResponse($categories);
    }

    public function fetchImagesForProducts($ids)
    {
        $images = array();
        foreach ($ids as $id) {
            $key = self::$PRODUCT_IMAGES_TRANSIENT_KEY . '_id' . $id;

            if (($transient = $this->wordpress->getTransient($key)) !== false) {
                $images[] = $this->parseResponse($transient);
                continue;
            } 

            $productImagesResponse = $this->request->get("/api/v2/products/{$id}/images.json");

            $this->wordpress->setTransient($key, $productImagesResponse, self::$DEFAULT_CACHE_PERIOD);

            $images[] = $this->parseResponse($productImagesResponse);
        }
        return $images;
    }

    public function findCategories($ids)
    {
        if (!is_array($ids)) $ids = array($ids);

        $allCategories = $this->fetchCategories();

        $categories = array();
        foreach($allCategories as $category) {

            if (in_array($category->id, $ids)) array_push($categories, $category);

        }
        return $categories;
    }

    private function parseResponse($response)
    {
        $json = new Services_JSON();
        return $json->decode($response);
    }

    public static function shortcode($atts, $content = null)
    {
        $wordpress = new WPBigcommerceWordpressFunctions();
        $options = $wordpress->getOption('wp_bigcommerce_options');
        $atts = $wordpress->shortcodeAtts(array(
            'products' => '',
            'fields' => self::getFieldsString(),
        ), $atts);

        $request = new WPBigcommerceHttpRequest($options['api_url']);
        $request->auth($options['api_user'], $options['api_secret']);

        $wordpressProducts = new self($request);

        $allProducts = $wordpressProducts->fetchProducts();
        $ids = explode(',', $atts['products']);
        if ($atts['products'] === '') $ids = array($allProducts[rand(0, count($allProducts)-1)]->id);

        $products = array();
        foreach ($allProducts as $product) {
            if (in_array($product->id, $ids)) array_push($products, $product);
        }

        $view = new WPBigcommerceView('product', array(
            'products' => $products,
            'store_url' => $options['api_url'],
            //'categories' => $wordpressProducts->findCategories($product->categories),
            'fields' => explode(',', $atts['fields']),
            ));
        echo $view->render();
    }
}