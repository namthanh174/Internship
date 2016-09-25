<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>
<h2> S3 Settings</h2>

    <div class="container">
        <form action='' method='POST' id='s3-setting-form'>
            <?php settings_fields( 's3_options' ); ?>
            <?php do_settings_sections('s3_options'); ?>
            <div><span>Bucket name : </span>
                <input type="text" name="s3_name" id="s3_name" class="s3_setting" value="<?php echo get_option('s3_name'); ?>" />
            </div>
            <div><span>Access Key ID : </span>
                <input type="text" name="s3_key_id" id="s3_key_id" class="s3_setting" value="<?php echo get_option('s3_key_id'); ?>" />
            </div>
            <div><span>Secret Access Key : </span>
                <input type="text" name="s3_secret_key" id="s3_secret_key" class="s3_setting" value="<?php echo get_option('s3_secret_key'); ?>" />
            </div>
            <br />
            <div><input class="button-primary" type="submit" id="save_s3_setting" name="save_s3_setting" value="<?php esc_attr_e( 'Save Changes' ); ?>" /></div>
        </form>
    </div>
