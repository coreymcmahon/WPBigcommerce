<?php

require_once(dirname(__FILE__) . '/../bootstrap.php');

class WPBigcommerceProducts
{
    /** @var \WpBigcommerceHttpRequest */
    private $request;
    private $limit;
    private $page;

    /**
     * @param WpBigcommerceHttpRequest $request
     * @param null $page
     * @param null $limit
     */
    public function __construct($request, $page = null, $limit = null)
    {
        $this->request = $request;
        $this->page  = ($page  !== null) ? $page  : 1;
        $this->limit = ($limit !== null) ? $limit : 10;
    }

    public function fetch()
    {
        $products = $this->request->get('/api/v2/products.json', array('page' => $this->page, 'limit' => $this->limit));
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
        $request = new WPBigcommerceHttpRequest('https://store-3hdjd3.mybigcommerce.com');
        $request->auth('admin', '1efd11a7e371c75aaebab73d65ce5ef285b98d0b');
        $products = new self($request);

        foreach ($products->fetch() as $product) {
            $view = new WPBigcommerceView('product', array('product' => $product));
            echo $view->render();
            continue;
            echo '<ul>';
            echo '<li><label>id</label> ' . $product->id . '</li>';
            echo '<li><label>keyword_filter</label> ' . $product->keyword_filter . '</li>';
            echo '<li><label>name</label> ' . $product->name . '</li>';
            echo '<li><label>type</label> ' . $product->type . '</li>';
            echo '<li><label>sku</label> ' . $product->sku . '</li>';
            //echo '<li><label>description</label> ' . $product->description . '</li>';
            echo '<li><label>search_keywords</label> ' . $product->search_keywords . '</li>';
            echo '<li><label>availability_description</label> ' . $product->availability_description . '</li>';
            echo '<li><label>price</label> ' . $product->price . '</li>';
            echo '<li><label>cost_price</label> ' . $product->cost_price . '</li>';
            echo '<li><label>retail_price</label> ' . $product->retail_price . '</li>';
            echo '<li><label>sale_price</label> ' . $product->sale_price . '</li>';
            echo '<li><label>calculated_price</label> ' . $product->calculated_price . '</li>';
            echo '<li><label>sort_order</label> ' . $product->sort_order . '</li>';
            echo '<li><label>is_visible</label> ' . $product->is_visible . '</li>';
            echo '<li><label>is_featured</label> ' . $product->is_featured . '</li>';
            echo '<li><label>related_products</label> ' . $product->related_products . '</li>';
            echo '<li><label>inventory_level</label> ' . $product->inventory_level . '</li>';
            echo '<li><label>inventory_warning_level</label> ' . $product->inventory_warning_level . '</li>';
            echo '<li><label>warranty</label> ' . $product->warranty . '</li>';
            echo '<li><label>weight</label> ' . $product->weight . '</li>';
            echo '<li><label>width</label> ' . $product->width . '</li>';
            echo '<li><label>height</label> ' . $product->height . '</li>';
            echo '<li><label>depth</label> ' . $product->depth . '</li>';
            echo '<li><label>fixed_cost_shipping_price</label> ' . $product->fixed_cost_shipping_price . '</li>';
            echo '<li><label>is_free_shipping</label> ' . $product->is_free_shipping . '</li>';
            echo '<li><label>inventory_tracking</label> ' . $product->inventory_tracking . '</li>';
            echo '<li><label>rating_total</label> ' . $product->rating_total . '</li>';
            echo '<li><label>rating_count</label> ' . $product->rating_count . '</li>';
            echo '<li><label>total_sold</label> ' . $product->total_sold . '</li>';
            echo '<li><label>date_created</label> ' . $product->date_created . '</li>';
            echo '<li><label>brand_id</label> ' . $product->brand_id . '</li>';
            echo '<li><label>view_count</label> ' . $product->view_count . '</li>';
            echo '<li><label>page_title</label> ' . $product->page_title . '</li>';
            echo '<li><label>meta_keywords</label> ' . $product->meta_keywords . '</li>';
            echo '<li><label>meta_description</label> ' . $product->meta_description . '</li>';
            echo '<li><label>layout_file</label> ' . $product->layout_file . '</li>';
            echo '<li><label>is_price_hidden</label> ' . $product->is_price_hidden . '</li>';
            echo '<li><label>price_hidden_label</label> ' . $product->price_hidden_label . '</li>';
            echo '<li><label>date_modified</label> ' . $product->date_modified . '</li>';
            echo '<li><label>event_date_field_name</label> ' . $product->event_date_field_name . '</li>';
            echo '<li><label>event_date_type</label> ' . $product->event_date_type . '</li>';
            echo '<li><label>event_date_start</label> ' . $product->event_date_start . '</li>';
            echo '<li><label>event_date_end</label> ' . $product->event_date_end . '</li>';
            echo '<li><label>myob_asset_account</label> ' . $product->myob_asset_account . '</li>';
            echo '<li><label>myob_income_account</label> ' . $product->myob_income_account . '</li>';
            echo '<li><label>myob_expense_account</label> ' . $product->myob_expense_account . '</li>';
            echo '<li><label>peachtree_gl_account</label> ' . $product->peachtree_gl_account . '</li>';
            echo '<li><label>condition</label> ' . $product->condition . '</li>';
            echo '<li><label>is_condition_shown</label> ' . $product->is_condition_shown . '</li>';
            echo '<li><label>preorder_release_date</label> ' . $product->preorder_release_date . '</li>';
            echo '<li><label>is_preorder_only</label> ' . $product->is_preorder_only . '</li>';
            echo '<li><label>preorder_message</label> ' . $product->preorder_message . '</li>';
            echo '<li><label>order_quantity_minimum</label> ' . $product->order_quantity_minimum . '</li>';
            echo '<li><label>order_quantity_maximum</label> ' . $product->order_quantity_maximum . '</li>';
            echo '<li><label>open_graph_type</label> ' . $product->open_graph_type . '</li>';
            echo '<li><label>open_graph_title</label> ' . $product->open_graph_title . '</li>';
            echo '<li><label>open_graph_description</label> ' . $product->open_graph_description . '</li>';
            echo '<li><label>is_open_graph_thumbnail</label> ' . $product->is_open_graph_thumbnail . '</li>';
            echo '<li><label>upc</label> ' . $product->upc . '</li>';
            echo '<li><label>date_last_imported</label> ' . $product->date_last_imported . '</li>';
            echo '<li><label>option_set_id</label> ' . $product->option_set_id . '</li>';
            echo '<li><label>tax_class_id</label> ' . $product->tax_class_id . '</li>';
            echo '<li><label>option_set_display</label> ' . $product->option_set_display . '</li>';
            echo '<li><label>bin_picking_number</label> ' . $product->bin_picking_number . '</li>';
            echo '<li><label>custom_url</label> ' . $product->custom_url . '</li>';
            echo '<li><label>availability</label> ' . $product->availability . '</li>';
            echo '</ul>';
            echo '<hr/>';
        }
    }
}