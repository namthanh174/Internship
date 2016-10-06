<?php


    ?>

    <!-- <h2>Multiple Scrape</h2> -->

    <div class="container">
        <form action='' method='POST' id='scrape-multi-form'>

            <table class="form-table">
                <tr>
                    <th><h4><?php esc_attr_e( 'URL Category : ', 'wp_admin_style' ); ?></h4></th>
                    <td><input type="text" id="url_multi" style="width:100%"></td>
                </tr>
                <tr>
                    <th><h4><?php esc_attr_e( 'Category : ', 'wp_admin_style' ); ?></h4></th>
                    <td>
                        <?php  include('show_add_category.php'); ?>
                    </td>
                </tr>
                

            </table>

            
            

            <input class="button-primary" type="submit" id="post_multi" name="post_multi" value="<?php esc_attr_e( 'Submit' ); ?>" />

        </form>
         <br />
         <div class="result2"></div>
<!--        <br />
        <div class="load2" style="float:left"></div>-->
        <div id="wait2"><img  src="<?php echo plugin_dir_url(__FILE__) . '../../images/waiting.gif'; ?>"></div>
        
        
        <!--<div id="prog"></div>-->
<!--	<div id="progressbar">
              <div class="progress-label"></div>
        </div>-->

    </div>

