

<h2>Settings</h2>

    <div class="container">
        <form action='options.php' method='POST' id='scrape-setting-form'>
            <?php settings_fields( 'scrape_options' ); ?>
            <?php do_settings_sections('scrape_options'); ?>

            
            <input type="checkbox" name="wp_upload_enable" id="wp_upload_enable" value="checked"  <?php echo get_option('wp_upload_enable') ?>  /> Upload into WP media<br>
            <input type="checkbox" name="aws_upload_enable" id="aws_upload_enable" value="checked" <?php echo get_option('aws_upload_enable') ?> /> Upload into AWS S3 Bucket<br>
            
                
    		


            <div><input type="submit" value='<?php _e('Save Changes') ?>' id="save_setting"></div>

        </form>
        

    </div>


