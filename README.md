# Wordpress Bigcommerce Products Plugin


## Installation
Clone the repository into your ```wordpress-install/wp-content/plugins``` directory as such:

```
$ git clone git@github.com:coreymcmahon/WPBigcommerce.git WPBigcommerce
```


## Run the Unit Tests
First, install the package dependencies using [composer](http://getcomposer.org/):

```
$ composer install --dev
```


## Usage
You can now enable the plugin by navigating to the Wordpress admin page, clicking on *Plugins* in the menu on the left-hand side of the screen and clicking the *Activate* button next to *WP Bigcommerce*.

Place a product listing on a page or post using the following shortcode syntax:

```
[wpbigcommerce products=72,73,81]
```

Where ```72,73,81``` is the list of product IDs you'd like displayed. You can also change which fields will be displayed using the syntax:

```
[wpbigcommerce products=72,73,81 fields=name,image,sku,description,price]
```

### Available Fields
* name <sup>\*</sup>
* image <sup>\*</sup>
* sku <sup>\*</sup>
* price <sup>\*</sup>
* retail_price
* sale_price
* warranty <sup>\*</sup>
* rating <sup>\*</sup>
* categories <sup>\*</sup>
* condition <sup>\*</sup>
* availability_description
* is_free_shipping
* upc
* weight <sup>\*</sup>
* width
* height
* depth
* description_snippet <sup>\*</sup>
* description
* description_html
* link <sup>\*</sup>

\*: show by default


## Frequently Asked Questions
### How do I find the ID for a product?
The easiest way to do this is to log in to your Bigcommerce store admin, click on the "Products" link in the top menu and then "View Products." Navigate through the list of products until you find the one you want to include on your Wordpress blog and click on the product title to go to the edit page.

Once here, you can find the product ID by looking at the URL in the address bar for your browser. You'll see something like this:

```
https://www.yourstorename.com/admin/index.php?ToDo=editProduct&productId=72
```

The product ID in this case is 72 (you can see it at the end of the URL above, where it says "productId=72").



## Coming soon...
* Dialog window to automate shortcode creation (select the product(s) you want displayed from a user interface instead of having to supply the ID)
