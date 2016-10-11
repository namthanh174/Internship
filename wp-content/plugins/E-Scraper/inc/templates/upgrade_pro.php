



<!-- <h2><?php //esc_attr_e( 'Form Elements: Input Fields', 'wp_admin_style' ); ?></h2>

<span class="title">License</span>
<input type="text" value="" class="regular-text" />
<span class="description"><?php //esc_attr_e( 'This is a description for a form element.', 'wp_admin_style' ); ?></span><br>
<span class="title">Secret Access key</span>
<input type="text" value=".regular-text" class="regular-text" />
<span class="description"><?php //esc_attr_e( 'This is a description for a form element.', 'wp_admin_style' ); ?></span><br> -->

<form action='' method='POST' id='upgrade-pro-form'>
            <table class="form-table">
            <tr>
                <th><h4><?php esc_attr_e( 'License : ', 'wp_admin_style' ); ?></h4></th>
                <td><input type="text" name="input_license" id="input_license"  style="width: 100%" /></td>
            </tr>
            <tr>
                <th><h4><?php esc_attr_e( 'Secret Access Key : ', 'wp_admin_style' ); ?></h4></th>
                <td><input type="text" name="input_secret_key" id="input_secret_key" style="width: 100%" /></td>
            </tr>
            

            </table>
            <input class="button-primary" type="submit" id="upgrade_pro_submit" name="upgrade_pro_submit" value="<?php esc_attr_e( 'Submit' ); ?>" />

</form>