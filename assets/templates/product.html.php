<div class="wp-bc-products">
    <?php foreach($products as $product): ?>
    <div class="wp-bc-product wp-bc-product-<?php echo $product->id; ?>">
        <?php foreach ($fields as $field): ?>
            <!-- name -->
            <?php if (strtolower($field) === 'name'): ?>
                <h2 class="wp-bc-product-name">
                    <?php echo $product->name; ?>
                </h2>
            <?php endif; ?>

            <!-- image -->
            <?php if (strtolower($field) === 'image'): ?>
            <div class="wp-bc-product-image">
                <img src="<?php echo "{$store_url}/product_images/{$product->image->image_file}"; ?>" 
                     alt="<?php echo $product->name; ?>" 
                     <?php 
                     if (!empty($image_width)) echo "width=\"{$image_width}\" ";
                     
                     if (!empty($image_height)) echo "height=\"{$image_height}\" ";

                     echo "style=\"";
                     if (!empty($image_width)) echo "width: {$image_width}px;";
                     if (!empty($image_height)) echo "height: {$image_height}px;";
                     echo "\"";
                     ?>
                />
            </div>
            <?php endif; ?>


            <div class="wp-bc-fields">

            <!-- sku -->
            <?php if (strtolower($field) === 'sku'): ?>
                <div class="wp-bc-product-sku">
                    <div class="wp-bc-label">SKU:</div>
                    <div class="wp-bc-value"><?php echo $product->sku; ?></div>
                </div>
            <?php endif; ?>

            <!-- price -->
            <?php if (strtolower($field) === 'price'): ?>
                <div class="wp-bc-product-price">
                    <div class="wp-bc-label">Price:</div>
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

            <!-- retail price -->
            <?php if (strtolower($field) === 'retail_price'): ?>
                <div class="wp-bc-product-retail_price">
                    <div class="wp-bc-label">Retail Price:</div>
                    <div class="wp-bc-value">
                        <?php echo $store->currency_symbol; ?>
                        <?php echo number_format(
                            (float)$product->retail_price,
                            (int)$store->decimal_places,
                            $store->decimal_separator,
                            $store->thousands_separator
                        ); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- sale price -->
            <?php if (strtolower($field) === 'sale_price'): ?>
                <div class="wp-bc-product-sale_price">
                    <div class="wp-bc-label">Sale Price:</div>
                    <div class="wp-bc-value">
                        <?php echo $store->currency_symbol; ?>
                        <?php echo number_format(
                            (float)$product->sale_price,
                            (int)$store->decimal_places,
                            $store->decimal_separator,
                            $store->thousands_separator
                        ); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- warranty -->
            <?php if (strtolower($field) === 'warranty'): ?>
                <div class="wp-bc-product-warranty">
                    <div class="wp-bc-label">Warranty:</div>
                    <div class="wp-bc-value"><?php echo $product->warranty; ?></div>
                </div>
            <?php endif; ?>

            <!-- rating -->
            <?php if (strtolower($field) === 'rating'): ?>
                <div class="wp-bc-product-rating">
                    <div class="wp-bc-label">Rating:</div>
                    <div class="wp-bc-value">
                        <?php if ($product->rating_count == 0): ?>
                        <span class="wp-bc-rating-total wp-bc-rating-no-ratings">No ratings.</span>
                        <?php else: ?>
                        <span class="wp-bc-rating-total"><?php echo $product->rating_total; ?>/5</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- categories -->
            <?php if (strtolower($field) === 'categories'): ?>
                <div class="wp-bc-product-categories">
                    <div class="wp-bc-label">Categor<?php echo count($product->categories) > 1 ? 'es' : 'y'; ?>:</div>
                    <div class="wp-bc-value">
                        <?php foreach ($product->categories as $category): ?>
                        <div class="wp-bc-product-category-<?php echo $category->id; ?>">
                            <?php echo $category->name; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- condition -->
            <?php if (strtolower($field) === 'condition'): ?>
                <div class="wp-bc-product-condition">
                    <div class="wp-bc-label">Condition:</div>
                    <div class="wp-bc-value"><?php echo $product->condition; ?></div>
                </div>
            <?php endif; ?>

            <!-- availability description -->
            <?php if (strtolower($field) === 'availability_description'): ?>
                <div class="wp-bc-product-availability-description">
                    <div class="wp-bc-label">Availability:</div>
                    <div class="wp-bc-value"><?php echo $product->availability_description; ?></div>
                </div>
            <?php endif; ?>

            <!-- free shipping? -->
            <?php if (strtolower($field) === 'is_free_shipping'): ?>
                <div class="wp-bc-product-is-free-shipping">
                    <div class="wp-bc-label">Free Shipping?:</div>
                    <div class="wp-bc-value">
                        <?php echo $product->is_free_shipping ? 'Y' : 'N'; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- UPC -->
            <?php if (strtolower($field) === 'upc'): ?>
                <div class="wp-bc-product-upc">
                    <div class="wp-bc-label">UPC:</div>
                    <div class="wp-bc-value"><?php echo $product->upc; ?></div>
                </div>
            <?php endif; ?>

            <!-- weight -->
            <?php if (strtolower($field) === 'weight'): ?>
                <div class="wp-bc-product-weight">
                    <div class="wp-bc-label">Weight:</div>
                    <div class="wp-bc-value">
                        <?php echo number_format(
                            (float)$product->weight,
                            (int)$store->decimal_places,
                            $store->decimal_separator,
                            $store->thousands_separator
                        ); ?> 
                        <?php echo $store->weight_units; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- width -->
            <?php if (strtolower($field) === 'width'): ?>
                <div class="wp-bc-product-width">
                    <div class="wp-bc-label">Width:</div>
                    <div class="wp-bc-value">
                        <?php echo number_format(
                            (float)$product->width,
                            (int)$store->decimal_places,
                            $store->decimal_separator,
                            $store->thousands_separator
                        ); ?> 
                        <?php echo $store->dimension_units; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- height -->
            <?php if (strtolower($field) === 'height'): ?>
                <div class="wp-bc-product-height">
                    <div class="wp-bc-label">Height:</div>
                    <div class="wp-bc-value">
                        <?php echo number_format(
                            (float)$product->height,
                            (int)$store->decimal_places,
                            $store->decimal_separator,
                            $store->thousands_separator
                        ); ?> 
                        <?php echo $store->dimension_units; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- depth -->
            <?php if (strtolower($field) === 'depth'): ?>
                <div class="wp-bc-product-depth">
                    <div class="wp-bc-label">Depth:</div>
                    <div class="wp-bc-value">
                        <?php echo number_format(
                            (float)$product->depth,
                            (int)$store->decimal_places,
                            $store->decimal_separator,
                            $store->thousands_separator
                        ); ?> 
                        <?php echo $store->dimension_units; ?>
                    </div>
                </div>
            <?php endif; ?>

            </div>

            <!-- description snippet -->
            <?php if (strtolower($field) === 'description_snippet'): ?>
                <div class="wp-bc-product-description-snippet">
                    <?php $description = substr(preg_replace('/<[^<]+?>/', ' ', $product->description), 0, 255); ?>
                    <?php echo $description ?>
                    <?php if (strlen($description) === 255) echo '&hellip;'; ?>
                </div>
            <?php endif; ?>

            <!-- description -->
            <?php if (strtolower($field) === 'description'): ?>
                <div class="wp-bc-product-description">
                    <?php echo preg_replace('/<[^<]+?>/', ' ', $product->description); ?>
                </div>
            <?php endif; ?>

            <!-- description html -->
            <?php if (strtolower($field) === 'description_html'): ?>
                <div class="wp-bc-product-description"><?php echo $product->description; ?></div>
            <?php endif; ?>

            <!-- link -->
            <?php if (strtolower($field) === 'link'): ?>
                <div class="wp-bc-product-link">
                    <a href="<?php echo "{$store_url}{$product->custom_url}"; ?>" target="<?php echo $link_target; ?>" style="<?php echo $link_style; ?>" class="<?php echo $link_class; ?>"><?php echo $link_text; ?></a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>