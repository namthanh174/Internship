





<form action='' method='POST' id='upgrade-pro-form'>
            <?php settings_fields( 'license_pro_options' ); ?>
            <?php do_settings_sections('license_pro_options'); ?>
            <table class="form-table">
            <tr>
                <th><h4><?php esc_attr_e( 'License : ', 'wp_admin_style' ); ?></h4></th>
                <td><input type="text" name="license" id="input_license" value="<?php echo get_option('license'); ?>"  style="width: 100%" /></td>
            </tr>
            <tr>
                <th><h4><?php esc_attr_e( 'Secret Access Key : ', 'wp_admin_style' ); ?></h4></th>
                <td><input type="password" name="secret_key" id="input_secret_key" value="<?php echo get_option('secret_key'); ?>" style="width: 100%" /></td>
            </tr>
            

            </table>
            <input class="button-primary" type="submit" id="upgrade_pro_submit" name="upgrade_pro_submit" value="<?php esc_attr_e( 'Submit' ); ?>" />
            <input class="delete button-primary" type="button" id="upgrade_pro_delete" name="upgrade_pro_delete" value="<?php esc_attr_e( 'Delete' ); ?>" />
            <!-- <input class="delete button-primary" type="button" id="check_api" name="upgrade_pro_delete" value="<?php //esc_attr_e( 'check api' ); ?>" /> -->


            <input type="hidden" name="isProVersion" value="true" />

</form>