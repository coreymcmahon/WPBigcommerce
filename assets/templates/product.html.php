<div class="wp-bc-products">
    <?php foreach($products as $product): ?>
    <div class="wp-bc-product wp-bc-product-<?php echo $product->id; ?>">
        
        <?php if (in_array('name', $fields)): ?>
            <h2 class="wp-bc-product-name"><?php echo $product->name; ?></h2>
        <?php endif; ?>

        <?php if (in_array('image', $fields)): ?>
            <div class="wp-bc-product-image">
                <img src="<?php echo "{$store_url}/product_images/{$product->image->image_file}"; ?>" 
                     alt="<?php echo $product->name; ?>" 
                     <?php 

                     if (!empty($image_width)) {
                        echo "width=\"{$image_width}\" ";
                     }
                     if (!empty($image_height)) {
                        echo "height=\"{$image_height}\" ";
                     }

                     echo "style=\"";
                     if (!empty($image_width)) echo "width: {$image_width}px;";
                     if (!empty($image_height)) echo "height: {$image_height}px;";
                     echo "\"";

                     ?>
                />
            </div>
        <?php endif; ?>

        <?php if (in_array('sku', $fields)): ?>
            <div class="wp-bc-product-sku"><?php echo $product->sku; ?></div>
        <?php endif; ?>

        <?php if (in_array('description', $fields)): ?>
            <div class="wp-bc-product-description">
                <?php $description = substr(preg_replace('/<[^<]+?>/', ' ', $product->description), 0, 255); ?>
                <?php echo $description ?>
                <?php if (strlen($description) === 255) echo '&hellip;'; ?>
            </div>
        <?php endif; ?>

        <?php if (in_array('description-html', $fields)): ?>
            <div class="wp-bc-product-description"><?php echo $product->description; ?></div>
        <?php endif; ?>

        <?php if (in_array('price', $fields)): ?>
            <div class="wp-bc-product-price">
                <div class="wp-bc-label">Price</div>
                <div class="wp-bc-value">
                    <?php echo $store->currency_symbol; ?>
                    <?php echo number_format(
                        (float)$product->price,
                        (int)$store->decimal_places,
                        $store->decimal_separator,
                        $store->thousands_separator
                    ); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (in_array('condition', $fields)): ?>
            <div class="wp-bc-product-condition">
                <div class="wp-bc-label">Condition</div>
                <div class="wp-bc-value"><?php echo $product->condition; ?></div>
            </div>
        <?php endif; ?>

        <?php if (in_array('warranty', $fields)): ?>
            <div class="wp-bc-product-warranty">
                <div class="wp-bc-label">Warranty</div>
                <div class="wp-bc-value"><?php echo $product->warranty; ?></div>
            </div>
        <?php endif; ?>

        <?php if (in_array('inventory', $fields)): ?>
            <div class="wp-bc-product-inventory">
                <div class="wp-bc-label">Inventory level</div>
                <div class="wp-bc-value"><?php echo $product->inventory_level; ?></div>
            </div>
        <?php endif; ?>

        <?php if (in_array('weight', $fields)): ?>
            <div class="wp-bc-product-weight">
                <div class="wp-bc-label">Weight</div>
                <div class="wp-bc-value"><?php echo $product->weight; ?></div>
            </div>
        <?php endif; ?>

        <?php if (in_array('width', $fields)): ?>
            <div class="wp-bc-product-width">
                <div class="wp-bc-label">Width</div>
                <div class="wp-bc-value"><?php echo $product->width; ?></div>
            </div>
        <?php endif; ?>

        <?php if (in_array('height', $fields)): ?>
            <div class="wp-bc-product-height">
                <div class="wp-bc-label">Height</div>
                <div class="wp-bc-value"><?php echo $product->height; ?></div>
            </div>
        <?php endif; ?>

        <?php if (in_array('depth', $fields)): ?>
            <div class="wp-bc-product-depth">
                <div class="wp-bc-label">Depth</div>
                <div class="wp-bc-value"><?php echo $product->depth; ?></div>
            </div>
        <?php endif; ?>

        <?php if (in_array('rating', $fields)): ?>
            <div class="wp-bc-product-rating">
                <div class="wp-bc-label">Rating</div>
                <div class="wp-bc-value"><?php echo $product->rating; ?></div>
            </div>
        <?php endif; ?>

        <?php if (in_array('rating-total', $fields)): ?>
            <div class="wp-bc-product-rating-total">
                <div class="wp-bc-label">Rating total</div>
                <div class="wp-bc-value"><?php echo $product->rating_total; ?></div>
            </div>
        <?php endif; ?>

        <?php if (in_array('rating-count', $fields)): ?>
            <div class="wp-bc-product-rating-rating-count">
                <div class="wp-bc-label">Rating count</div>
                <div class="wp-bc-value"><?php echo $product->rating_count; ?></div>
            </div>
        <?php endif; ?>

        <!-- @TODO: fix this
        <?php if (in_array('brand', $fields)): ?>
            <div class="wp-bc-product-brand">
            <div class="wp-bc-label">Brand</div>
            <div class="wp-bc-value"><?php print_r($product->brand, false); ?></div>
        </div>
        <?php endif; ?>
        -->

        <?php if (in_array('categories', $fields)): ?>
            <div class="wp-bc-product-categories">
                <?php foreach ($product->categories as $category): ?>
                <div class="wp-bc-product-category-<?php echo $category->id; ?>">
                </div>
                <?php endforeach; ?>
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