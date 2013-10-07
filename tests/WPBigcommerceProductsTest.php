<?php

class WPBigcommerceProductsTest extends PHPUnit_Framework_TestCase {

    private $request;
    private $products;
    private $wordpress;

    public function setUp()
    {
        $this->request = Mockery::mock('WPBigcommerceHttpRequest');
        $this->wordpress = Mockery::mock('WPBigcommerceWordpressFunctions');
        $this->products = new WPBigcommerceProducts(
            $this->request,
            null,
            null,
            $this->wordpress
        );

    }

    public function testFetchProductsWithCacheMiss()
    {
        $this->wordpress->shouldReceive('getTransient')
            ->once()
            ->with(WPBigcommerceProducts::$PRODUCTS_TRANSIENT_KEY)
            ->andReturn(false);

        $this->request->shouldReceive('get')
            ->once()
            ->with('/api/v2/products.json', array('limit' => 250, 'page' => 1,))
            ->andReturn($this->productsApiResponse);

        $this->wordpress->shouldReceive('setTransient')
            ->once()
            ->with(WPBigcommerceProducts::$PRODUCTS_TRANSIENT_KEY, $this->productsApiResponse, WPBigcommerceProducts::$DEFAULT_CACHE_PERIOD)
            ->andReturn(false);

        $products = $this->products->fetchProducts();
        $this->assertEquals(32, $products[0]->id);
    }

    public function testFetchProductsWithCacheHit()
    {
        $this->wordpress->shouldReceive('getTransient')
            ->once()
            ->with(WPBigcommerceProducts::$PRODUCTS_TRANSIENT_KEY)
            ->andReturn($this->productsApiResponse);

        $products = $this->products->fetchProducts();
        $this->assertEquals(32, $products[0]->id);
    }

    public function testFetchCategoriesWithCacheMiss()
    {
        $this->wordpress->shouldReceive('getTransient')
            ->once()
            ->with(WPBigcommerceProducts::$CATEGORIES_TRANSIENT_KEY)
            ->andReturn(false);

        $this->request->shouldReceive('get')
            ->once()
            ->with('/api/v2/categories.json', array('limit' => 250, 'page' => 1,))
            ->andReturn($this->categoriesApiResponse);

        $this->wordpress->shouldReceive('setTransient')
            ->once()
            ->with(WPBigcommerceProducts::$CATEGORIES_TRANSIENT_KEY, $this->categoriesApiResponse, WPBigcommerceProducts::$DEFAULT_CACHE_PERIOD);

        $categories = $this->products->fetchCategories();
        $this->assertEquals('Mens', $categories[0]->name);
    }

    public function testFetchCategoriesWithCacheHit()
    {
        $this->wordpress->shouldReceive('getTransient')
            ->once()
            ->with(WPBigcommerceProducts::$CATEGORIES_TRANSIENT_KEY)
            ->andReturn($this->categoriesApiResponse);

        $categories = $this->products->fetchCategories();
        $this->assertEquals('Mens', $categories[0]->name);
    }

    public function testFetchImagesForProductsWithCacheMiss()
    {
        $ids = array(34, 35);

        foreach ($ids as $id) {
            $this->wordpress->shouldReceive('getTransient')
                ->once()
                ->with(WPBigcommerceProducts::$PRODUCT_IMAGES_TRANSIENT_KEY . "_id{$id}")
                ->andReturn(false);

            $this->request->shouldReceive('get')
                ->once()
                ->with("/api/v2/products/{$id}/images.json")
                ->andReturn($this->productImagesApiResponse);

            $this->wordpress->shouldReceive('setTransient')
                ->once()
                ->with(WPBigcommerceProducts::$PRODUCT_IMAGES_TRANSIENT_KEY . "_id{$id}", $this->productImagesApiResponse, WPBigcommerceProducts::$DEFAULT_CACHE_PERIOD);
        }

        $images = $this->products->fetchImagesForProducts($ids);

        $this->assertCount(2, $images);
        $this->assertEquals(250, $images[0][0]->id);
        $this->assertEquals(250, $images[1][0]->id);
    }

    public function testFetchImagesForProductsWithCacheHit()
    {
        $ids = array(34, 35);

        foreach ($ids as $id) {
            $this->wordpress->shouldReceive('getTransient')
                ->once()
                ->with(WPBigcommerceProducts::$PRODUCT_IMAGES_TRANSIENT_KEY . '_id' . $id)
                ->andReturn($this->productImagesApiResponse);
        }

        $images = $this->products->fetchImagesForProducts($ids);

        $this->assertCount(2, $images);
        $this->assertEquals(250, $images[0][0]->id);
        $this->assertEquals(250, $images[1][0]->id);
    }

    public function testShortcode()
    {
        $this->markTestIncomplete();
    }

    // Saved API responses
    private $productsApiResponse = '[{"id":32,"keyword_filter":null,"name":"[Sample] Tomorrow is today, Red printed scarf","type":"physical","sku":"","description":"<p><strong>How to write product descriptions that sell<\/strong><br \/>One of the best things you can do to make your store successful is invest some time in writing great product descriptions. You want to provide detailed yet concise information that will entice potential customers to buy.<br \/><br \/>Keep three things in mind:<br \/><br \/><strong>Think like a consumer<\/strong><br \/>Think about what you as a consumer would want to know, then include those features in your description. For clothes: materials and fit. For food: ingredients and how it was prepared. Bullets are your friends when listing features &mdash; try to limit each one to 5-8 words.<br \/><br \/><strong>Find differentiators<\/strong><br \/>Pepper your features with details that show how the product stands out against similar offerings. For clothes: is it vintage or hard to find? For art: is the artist well known? For home d&eacute;cor: is it a certain style like mid-century modern? Unique product descriptions not only help you stand out, they improve your SEO.<br \/><br \/><strong>Keep it simple<\/strong><br \/>Provide enough detail to help consumers make an informed decision, but don&rsquo;t overwhelm with a laundry list of features or flowery language. Densely pack your descriptions with useful information and watch products fly off the shelf.<\/p>","search_keywords":null,"availability_description":"","price":"89.0000","cost_price":"0.0000","retail_price":"0.0000","sale_price":"0.0000","calculated_price":"89.0000","sort_order":0,"is_visible":true,"is_featured":true,"related_products":"-1","inventory_level":0,"inventory_warning_level":0,"warranty":null,"weight":"0.3000","width":"0.0000","height":"0.0000","depth":"0.0000","fixed_cost_shipping_price":"10.0000","is_free_shipping":false,"inventory_tracking":"none","rating_total":0,"rating_count":0,"total_sold":0,"date_created":"Fri, 21 Sep 2012 02:31:01 +0000","brand_id":17,"view_count":4,"page_title":"","meta_keywords":null,"meta_description":null,"layout_file":"product.html","is_price_hidden":false,"price_hidden_label":"","categories":[14],"date_modified":"Mon, 24 Sep 2012 01:34:57 +0000","event_date_field_name":"Delivery Date","event_date_type":"none","event_date_start":"","event_date_end":"","myob_asset_account":"","myob_income_account":"","myob_expense_account":"","peachtree_gl_account":"","condition":"New","is_condition_shown":false,"preorder_release_date":"","is_preorder_only":false,"preorder_message":"","order_quantity_minimum":0,"order_quantity_maximum":0,"open_graph_type":"product","open_graph_title":"","open_graph_description":null,"is_open_graph_thumbnail":true,"upc":null,"date_last_imported":"","option_set_id":null,"tax_class_id":0,"option_set_display":"right","bin_picking_number":"","custom_url":"\/tomorrow-is-today-red-printed-scarf\/","availability":"available","brand":{"url":"https:\/\/store-48whbcr.mybigcommerce.com\/api\/v2\/brands\/17.json","resource":"\/brands\/17"},"images":{"url":"https:\/\/store-48whbcr.mybigcommerce.com\/api\/v2\/products\/32\/images.json","resource":"\/products\/32\/images"},"discount_rules":{"url":"https:\/\/store-48whbcr.mybigcommerce.com\/api\/v2\/products\/32\/discountrules.json","resource":"\/products\/32\/discountrules"},"configurable_fields":{"url":"https:\/\/store-48whbcr.mybigcommerce.com\/api\/v2\/products\/32\/configurablefields.json","resource":"\/products\/32\/configurablefields"},"custom_fields":{"url":"https:\/\/store-48whbcr.mybigcommerce.com\/api\/v2\/products\/32\/customfields.json","resource":"\/products\/32\/customfields"},"videos":{"url":"https:\/\/store-48whbcr.mybigcommerce.com\/api\/v2\/products\/32\/videos.json","resource":"\/products\/32\/videos"},"skus":{"url":"https:\/\/store-48whbcr.mybigcommerce.com\/api\/v2\/products\/32\/skus.json","resource":"\/products\/32\/skus"},"rules":{"url":"https:\/\/store-48whbcr.mybigcommerce.com\/api\/v2\/products\/32\/rules.json","resource":"\/products\/32\/rules"},"option_set":null,"options":{"url":"https:\/\/store-48whbcr.mybigcommerce.com\/api\/v2\/products\/32\/options.json","resource":"\/products\/32\/options"},"tax_class":{"url":"https:\/\/store-48whbcr.mybigcommerce.com\/api\/v2\/taxclasses\/0.json","resource":"\/taxclasses\/0"}}]';
    private $categoriesApiResponse = '[{"id":1,"parent_id":0,"name":"Mens","description":"","sort_order":2,"page_title":"","meta_keywords":null,"meta_description":null,"layout_file":"category.html","parent_category_list":[1],"image_file":"","is_visible":true,"search_keywords":"","url":"\/mens\/"}]';
    private $productImagesApiResponse = '[{"id":250,"product_id":34,"image_file":"sample_images\/HERO_GF_sportG_91894__07966.jpg","is_thumbnail":true,"sort_order":0,"description":null,"date_created":"Mon, 24 Sep 2012 05:43:21 +0000"},{"id":251,"product_id":34,"image_file":"sample_images\/GF_sportG_91892__79067.jpg","is_thumbnail":false,"sort_order":1,"description":null,"date_created":"Mon, 24 Sep 2012 05:43:32 +0000"}]';
}