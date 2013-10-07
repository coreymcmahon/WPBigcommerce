<div class="wp-bc-products">
    <?php foreach($products as $product): ?>
    <div class="wp-bc-product wp-bc-product-<?php echo $product->id; ?>">
        
        <?php if (in_array('name', $fields)): ?>
            <h2 class="wp-bc-product-name"><?php echo $product->name; ?></h2>
        <?php endif; ?>
        
        <?php if (in_array('image', $fields)): ?>
            <div class="wp-bc-product-image">
                <!-- @TODO: fill this in -->
            </div>
        <?php endif; ?>

        <?php if (in_array('sku', $fields)): ?>
            <div class="wp-bc-product-sku"><?php echo $product->sku; ?></div>
        <?php endif; ?>

        <?php if (in_array('description', $fields)): ?>
            <div class="wp-bc-product-description"><?php echo substr(strip_tags($product->description), 255); ?></div>
        <?php endif; ?>

        <?php if (in_array('description-html', $fields)): ?>
            <div class="wp-bc-product-description"><?php echo $product->description; ?></div>
        <?php endif; ?>

        <?php if (in_array('price', $fields)): ?>
            <div class="wp-bc-product-price"><?php echo $product->price; ?></div>
        <?php endif; ?>

        <?php if (in_array('condition', $fields)): ?>
            <div class="wp-bc-product-condition"><?php echo $product->condition; ?></div>
        <?php endif; ?>

        <?php if (in_array('warranty', $fields)): ?>
            <div class="wp-bc-product-warranty"><?php echo $product->warranty; ?></div>
        <?php endif; ?>

        <?php if (in_array('inventory', $fields)): ?>
            <div class="wp-bc-product-inventory"><?php echo $product->inventory_level; ?></div>
        <?php endif; ?>

        <?php if (in_array('weight', $fields)): ?>
            <div class="wp-bc-product-weight"><?php echo $product->weight; ?></div>
        <?php endif; ?>

        <?php if (in_array('width', $fields)): ?>
            <div class="wp-bc-product-width"><?php echo $product->width; ?></div>
        <?php endif; ?>

        <?php if (in_array('height', $fields)): ?>
            <div class="wp-bc-product-height"><?php echo $product->height; ?></div>
        <?php endif; ?>

        <?php if (in_array('depth', $fields)): ?>
            <div class="wp-bc-product-depth"><?php echo $product->depth; ?></div>
        <?php endif; ?>

        <?php if (in_array('rating', $fields)): ?>
            <div class="wp-bc-product-rating"><?php echo $product->rating; ?></div>
        <?php endif; ?>

        <?php if (in_array('rating-total', $fields)): ?>
            <div class="wp-bc-product-rating-total"><?php echo $product->rating_total; ?></div>
        <?php endif; ?>

        <?php if (in_array('rating-count', $fields)): ?>
            <div class="wp-bc-product-rating-rating-count"><?php echo $product->rating_count; ?></div>
        <?php endif; ?>

        <?php if (in_array('brand', $fields)): ?>
            <div class="wp-bc-product-brand"><?php print_r($product->brand, false); ?></div>
        <?php endif; ?>

        <?php if (in_array('categories', $fields)): ?>
            <div class="wp-bc-product-categories">
                <!-- @TODO: fill this in -->  
            </div>
        <?php endif; ?>

        <?php if (in_array('link', $fields)): ?>
            <div class="wp-bc-product-link">
                <a href="<?php echo "{$store_url}{$product->custom_url}"; ?>">Buy Now</a>
            </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>