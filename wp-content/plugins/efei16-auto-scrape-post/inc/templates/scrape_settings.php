

<h2>Settings</h2>

    <div class="container">
        <form action='' method='POST' id='save_scrape_settings-form'>
            <?php settings_fields( 'scrape_options' ); ?>
            <?php do_settings_sections('scrape_options'); ?>

            <h3>Do you want to upload images to WP media or AWS S3 Bucket</h3>
            <input type="radio" name="upload_enable" id="upload_enable" value="wp_upload_enable"  <?php echo get_option('upload_enable'); ?> <?php if(get_option('upload_enable')=='wp_upload_enable'){ echo "checked";} ?>  /> Upload into WP media<br>
            <input type="radio" name="upload_enable" id="upload_enable" value="aws_upload_enable" <?php echo get_option('upload_enable'); ?> <?php if(get_option('upload_enable')=='aws_upload_enable'){ echo "checked";} ?>  /> Upload into AWS S3 Bucket<br>
            <br />
            <h3>Do you want to remove links out from the content</h3>            
            <input type="checkbox" name="remove_link" id="remove_link" value="checked" <?php echo get_option('remove_link') ?> /> Remove Link<br>
                

            <br />
            <input class="button-primary" type="submit" id="save_setting" name="save_setting" value="<?php esc_attr_e( 'Save Changes' ); ?>" />

        </form>
        

    </div>




		
		


