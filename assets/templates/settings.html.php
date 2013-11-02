<div class="wrap">
    <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e('WP Bigcommerce Settings'); ?></h2><br/>

    <form action="options.php" method="post">
        <?php settings_fields('wp_bigcommerce_options'); ?>
        <?php do_settings_sections(WPBC_PLUGIN_IDENTIFIER); ?>

        <?php submit_button(); ?>
    </form>

    <hr/>

    <h3><?php _e('Plugin Settings'); ?></h3><br/>

    <form method="post">
        <?php 
        if(isset($_POST['clear_cache'])) {
            $products = new WPBigcommerceProducts();
            $products->dumpTransients(); ?>
            <div class="updated settings-error"> 
                <p><strong>Cache cleared.</strong></p>
            </div>
    <?php
        } ?>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">Cache</th>
                    <td>
                        <input type="submit" name="clear_cache" id="clear_cache" class="button button-primary" value="Clear Cache" onclick="return confirm('Are you sure you want to clear the product cache?');">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>