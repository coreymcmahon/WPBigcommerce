<?php

class WPBigcommerceProducts
{
    public static $STORE_INFO_TRANSIENT_KEY = 'wp_bigcommerce_store';
    public static $PRODUCTS_TRANSIENT_KEY = 'wp_bigcommerce_products';
    public static $PRODUCT_IMAGES_TRANSIENT_KEY = 'wp_bigcommerce_product_images';
    public static $CATEGORIES_TRANSIENT_KEY = 'wp_bigcommerce_categories';

    /** @var \WpBigcommerceApi */
    private $api;
    /** @var \WpBigcommerceTransientCacher */
    private $cacher;
    /** @var \WpBigcommerceWordpressFunctions */
    private $wordpress;

    /**
     * @param \WpBigcommerceApi $api
     * @param \WpBigcommerceTransientCacher $cacher
     * @param \WpBigcommerceWordpressFunctions $wordpress
     */
    public function __construct($api = null, $cacher = null, $wordpress = null)
    {
        if ($api === null) $api = new WPBigcommerceApi;
        $this->api = $api;

        if ($cacher === null) $cacher = new WPBigcommerceTransientCacher;
        $this->cacher = $cacher;

        if ($wordpress === null) $wordpress = new WPBigcommerceWordpressFunctions;
        $this->wordpress = $wordpress;
    }

    public static function getFields($all = false)
    {
        $defaults = [
            'name',
            'image',
            'sku',
            'price',
            'warranty',
            'rating',
            'weight',
            'categories',
            'condition',
            'link',
            'description_snippet',
        ];
        $others = [
            'availability_description',
            'retail_price',
            'sale_price',
            'is_free_shipping',
            'upc',
            'width',
            'height',
            'depth',
            'description',
            'description_html',
        ];
        return ($all ? array_merge($defaults, $others) : $defaults);
    }

    public static function getFieldsString()
    {
        return implode(',', self::getFields());
    }

    public function testConnection()
    {
        return $this->api->testConnection();
    }

    public function findStoreInfo()
    {
        $key = self::$STORE_INFO_TRANSIENT_KEY;

        $info = $this->cacher->get($key);
        if (!empty($info)) return $info;

        $info = $this->api->getStoreInfo();
        if (empty($info)) return null;

        $this->cacher->set($key, $info);
        return $info;
    }

    public function findProduct($id)
    {
        $key = self::$PRODUCTS_TRANSIENT_KEY;

        $product = $this->getItemFromCache($key, $id);
        if (!empty($product)) return $product;

        $product = $this->api->getProductsByIds($id);
        if (empty($product)) return null;

        $this->addItemToCache($key, $id, $product[0]);
        return $product[0];
    }

    public function findCategory($id)
    {
        $key = self::$CATEGORIES_TRANSIENT_KEY;

        $category = $this->getItemFromCache($key, $id);
        if (!empty($category)) return $category;

        $category = $this->api->getCategory($id);
        if (empty($category)) return null;

        $this->addItemToCache($key, $id, $category);
        return $category;
    }

    public function findProductImage($id)
    {
        $key = self::$PRODUCT_IMAGES_TRANSIENT_KEY;

        $image = $this->getItemFromCache($key, $id);
        if (!empty($image)) return $image;

        $image = $this->api->getProductImage($id);
        if (empty($image)) return null;

        $this->addItemToCache($key, $id, $image);
        return $image;
    }

    public function dumpTransients()
    {
        $keys = array(
            self::$PRODUCTS_TRANSIENT_KEY,
            self::$PRODUCT_IMAGES_TRANSIENT_KEY,
            self::$CATEGORIES_TRANSIENT_KEY,
        );
        foreach ($keys as $key) {
            $ids = explode(',', $this->cacher->get($key));
            foreach ($ids as $id)
                if (!empty($id)) $this->cacher->clear("{$key}_{$id}");

            $this->cacher->clear($key);
        }
    }

    public function getItemFromCache($key, $id)
    {
        return $this->cacher->get("{$key}_{$id}", '');
    }

    public function addItemToCache($key, $id, $obj)
    {
        $this->cacher->set("{$key}_{$id}", $obj);
        $keys = $this->cacher->get("{$key}", '');
        return $this->cacher->set("{$key}", "{$keys}{$id},");
    }

    public static function shortcode($atts, $content = null)
    {
        $wpBigcommerceProducts = new self;
        $wordpress = new WpBigcommerceWordpressFunctions;

        $options = $wordpress->getOption('wp_bigcommerce_options');
        $atts = $wordpress->shortcodeAtts(array(
            'products' => '',
            'fields' => self::getFieldsString(),
            'image_width' => '200',
            'image_height' => '',
        ), $atts);

        $ids = explode(',', $atts['products']);
        
        $products = array();
        foreach ($ids as $id)
            $products[] = $wpBigcommerceProducts->findProduct($id);

        foreach ($products as &$product) {
            $product->image = $wpBigcommerceProducts->findProductImage($product->id);
            
            $categories = $product->categories;
            $product->categories = [];
            foreach ($categories as $category) {
                $product->categories[] = $wpBigcommerceProducts->findCategory($category);
            }
        }

        $view = new WPBigcommerceView('product', array(
            'store' => $wpBigcommerceProducts->findStoreInfo(),
            'products' => $products,
            'store_url' => $options['api_url'],
            'fields' => explode(',', $atts['fields']),
            'image_width' => $atts['image_width'],
            'image_height' => $atts['image_height'],
        ));
        echo $view->render();
    }
}