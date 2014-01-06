=== Plugin Name ===
Contributors: coreymcmahon
Donate link: http://www.commercecoders.com/
Tags: bigcommerce, big commerce, commerce, ecommerce, e-commerce, cart, shopping cart, interspire
Requires at least: 3.0
Tested up to: 3.8
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Bigcommerce is the quickest and easiest way to list products from your Bigcommerce store on your Wordpress blog.

== Description ==

*WP Bigcommerce* enables Bigcommerce store owners to list their products on Wordpress blogs. By using a simple shortcode you can quickly and easily list products on pages and posts.

Once the plugin is [installed](http://wordpress.org/plugins/wp-bigcommerce/installation/), you can place a product listing on a page or post using the following shortcode syntax:

`
[wpbigcommerce products=72,73,81]
`

Where `72,73,81` is the list of product IDs you'd like displayed. You can also change which fields will be displayed using the syntax:

`
[wpbigcommerce products=72,73,81 fields=name,image,sku,description,price]
`

= Available fields =
You can control which fields will be displayed in the product listing by changing the `fields` attribute in the shortcode. The following values are currently available:

* name<sup>\*</sup>
* image<sup>\*</sup>
* sku<sup>\*</sup>
* price<sup>\*</sup>
* retail_price
* sale_price
* warranty<sup>\*</sup>
* rating<sup>\*</sup>
* categories<sup>\*</sup>
* condition<sup>\*</sup>
* availability_description
* is_free_shipping
* upc
* weight<sup>\*</sup>
* width
* height
* depth
* description_snippet<sup>\*</sup>
* description
* description_html
* link<sup>\*</sup>

\*: show by default


== Installation ==

= Installation from within Wordpress =
1. Log in to your Wordpress site's backend and navigate to the *Plugins* > *Add New* page.
1. Search for `WP Bigcommerce`.
1. Click on the *Install* button underneath *WP Bigcommerce*.
1. Navigate to the *Settings*, *WP Bigcommerce* page.
1. Add your Bigcommerce API details and click save.

= Manual Installation =
1. Upload `wp-bigcommerce.zip` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to the *Settings* > *WP Bigcommerce* page.
1. Add your Bigcommerce API details and click save.

== Frequently Asked Questions ==

= Where do I find my Bigcommerce API settings? =

Your Bigcommerce API settings can be accessed from the backend of your Bigcommerce store. Click on the *Users* link in the top navigation bar (black background, white text) and then select a Bigcommerce user. Scroll down to the bottom of the page and ensure that "Allow User to Access the API" is checked. The API username, URL and secret will be displayed here.

= How do I find the ID for a product? =

The easiest way to do this is to log in to your Bigcommerce store admin, click on the "Products" link in the top menu and then "View Products." Navigate through the list of products until you find the one you want to include on your Wordpress blog and click on the product title to go to the edit page.

Once here, you can find the product ID by looking at the URL in the address bar for your browser. You'll see something like this:

`
https://www.yourstorename.com/admin/index.php?ToDo=editProduct&productId=72
`

The product ID in this case is 72 (you can see it at the end of the URL above, where it says "productId=72").

= Why does the plugin show different product information to what's in my store? =
WP Bigcommerce saves (or "caches") information from you store so that it only needs to retrieve a product once. This makes it much faster, but it means the information won't be accurate if you change the product details in your store.

You can fix this by "dumping" the cache. Go to the Settings > WP Bigcommerce page in your Wordpress backend and click the "Clear Cache" button.

= PressTrends =

This plugin uses [PressTrends](http://www.presstrends.io/) to gather anonymous usage statistics. By installing the plugin you agree to allow PressTrends to receive this information.

== Screenshots ==

1. Quickly and easily list products from your Bigcommerce store on your Wordpress sites.
2. Control which fields are displayed to customise the product listing.

== Changelog ==

= 1.2 =
* Fixed bug with older PHP versions.

= 1.1 =
* Made fields orderable.
* Added weight and dimensions units.
* Added attributes to customise link: ```link_text```, ```link_class```, ```link_style```, ```link_target```.

= 1.0 =
Initial release.

== Upcoming features ==

* Dialog window to automate shortcode creation (select product[s] from a user interface instead of having to supply the ID).
* Change the order in which fields are displayed in the product template.
* Tracking for referrals back to your Bigcommerce store.
