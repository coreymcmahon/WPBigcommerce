<?php 

class WPBigcommerceApi {

    private $request;
    private $json;

    public function __construct($request = null, $json = null)
    {
        if ($request === null) {
            $wordpress = new WPBigcommerceWordpressFunctions;
            $options = $wordpress->getOption('wp_bigcommerce_options');

            $request = new WPBigcommerceHttpRequest($options['api_url']);
            $request->auth($options['api_user'], $options['api_secret']);
        }
        $this->request = $request;
        
        if (!$json) $json = new Services_JSON();
        $this->json = $json;
    }

    public function testConnection()
    {
        $time = $this->request->get('/api/v2/time.json');
        return $time !== null;
    }

    public function getStoreInfo()
    {
        $store = $this->request->get('/api/v2/store.json');
        return $this->json->decode($store);
    }

    public function getProducts($page = 1, $limit = 250)
    {
        $products = $this->request->get('/api/v2/products.json', array('page' => $page, 'limit' => $limit));
        return $this->json->decode($products);
    }

    public function getCategories($page = 1, $limit = 250)
    {
        $categories = $this->request->get('/api/v2/categories.json', array('page' => $page, 'limit' => $limit));
        return $this->json->decode($categories);
    }

    public function getCategory($id)
    {
        $category = $this->request->get("/api/v2/categories/{$id}.json");
        return $this->json->decode($category);
    }

    public function getProductsByIds($ids = array())
    {
        if (!is_array($ids)) $ids = array($ids);

        $products = array();
        foreach ($ids as $id) {
            $product = $this->request->get("/api/v2/products/{$id}.json");
            if ($product && ($product = $this->json->decode($product))) $products[] = $product;
        }
        return $products;
    }

    public function getProductImagesByProductIds($productIds = array())
    {
        if (!is_array($productIds)) $productIds = array($productIds);

        $images = array();
        foreach ($productIds as $id) {
            $productImages = $this->request->get("/api/v2/products/{$id}/images.json");
            if ($productImages && ($productImages = $this->json->decode($productImages))) $images[] = $productImages;
        }
        return $images;
    }

    public function getProductImage($id)
    {
        $images = $this->getProductImagesByProductIds($id);

        if (is_array($images))
            foreach ($images[0] as $image)
                if ($image->is_thumbnail) return $image;
        
        return null;
    }
}