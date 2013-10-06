<div class="wrap">
    <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e('WP Bigcommerce Settings'); ?></h2><br/>

    <form action="options.php" method="post">
        <?php settings_fields('wp_bigcommerce_options'); ?>
        <?php do_settings_sections(WPBC_PLUGIN_IDENTIFIER); ?>

        <?php submit_button(); ?>
    <form>

	<?php /*
    <form method="post">
    	<p class="submit">
    		<input type="submit" name="clear_cache" id="clear_cache" class="button button-primary" value="Clear Cache">
    	</p>
    </form>
    */ ?>
</div>