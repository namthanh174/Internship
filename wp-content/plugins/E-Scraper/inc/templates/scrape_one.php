

<div class="wrap">

    <!-- <div id="icon-options-general" class="icon32"></div> -->
   

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">

            <!-- main content -->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable">

                    <div class="postbox">

                        <h2><span><?php esc_attr_e( 'Scrape And Post To Wordpress', 'wp_admin_style' ); ?></span></h2>

                        <div class="inside">



                            <form action='' method='POST' id='scrape-one-form'>
                            <?php // settings_fields( 'scrape_options' ); ?>
                            <?php // do_settings_sections('scrape_options'); ?>

           <table class="form-table">
           <tr> <th width="150"><h4><?php esc_attr_e( 'URL: ', 'wp_admin_style' ); ?></h4></th>
            <td><input type="text" id="url_one" style="width:100%"></td>
            </tr>
            
            <tr>
               <th><h4><?php esc_attr_e( 'Choose Scrape :', 'wp_admin_style' ); ?></h4></th>

            
             <!-- <h3>Choose Post Status</h3> -->
            <td>        
                <input type="radio" name="choose_scrape" id="choose_one_aritcle" class="choose_one_aritcle" value="one" checked="checked" />Scrape one article <br /><br />
                <input type="radio" name="choose_scrape" id="choose_category" class="choose_category" value="multi" <?php echo $choose_category; ?> /> Scrape category
            
            </td>
            
            </tr>


            
            <tr>
               <th><h4><?php esc_attr_e( 'Choose Post Status :', 'wp_admin_style' ); ?></h4></th>

            
             <!-- <h3>Choose Post Status</h3> -->
            <td>        
                <input type="radio" name="choose_status" class="choose_draft" value="draft" checked="checked" /> Draft <br /><br />
                <input type="radio" name="choose_status" class="choose_publish" value="publish" /> Published<br>
                
            
            </td>
            
            </tr>

            <tr>
               <th><h4><?php esc_attr_e( 'Choose Upload Images :', 'wp_admin_style' ); ?></h4></th>
            
             <!-- <h3>Choose Post Status</h3> -->
            <td>        
                <input type="radio" name="upload_enable" id='wp_upload_enable' value="wp_upload_enable" checked="checked" /> WP media <br /><br />
                <input type="radio" name="upload_enable" id="aws_upload_enable"  value="aws_upload_enable"  <?php echo $choose_aws_s3; ?> /> AWS S3 Bucket
                
            
            </td>
            
            </tr>

            <tr>
               <th><h4><?php esc_attr_e( 'Remove Links :', 'wp_admin_style' ); ?></h4></th>
            
             <!-- <h3>Choose Post Status</h3> -->
            <td>        
                <input type="checkbox" name="remove_link" id="remove_link" value="checked"  /> Remove Link
                
            
            </td>
            
            </tr>



            </table>

            <input class="button-primary" type="submit" id="post_one" name="post_one" value="<?php esc_attr_e( 'Submit' ); ?>" />
        </form>
        <br />
        <div id="progressbar">
             <div class="progress-label">
                 
            </div>
         </div>

        <div class="result1"></div>
        <!-- <div id="wait1"><img  src="<?php echo plugin_dir_url(__FILE__) . '../../images/waiting.gif'; ?>"></div> -->
         



                        </div>
                        <!-- .inside -->

                    </div>
                    <!-- .postbox -->

                </div>
                <!-- .meta-box-sortables .ui-sortable -->

            </div>
            <!-- post-body-content -->

            <!-- sidebar -->
            <div id="postbox-container-1" class="postbox-container">

                <div class="meta-box-sortables">

                    <div class="postbox">

                        <h2><span><?php esc_attr_e(
                                    'Choose category', 'wp_admin_style'
                                ); ?></span></h2>

                        <div class="inside">
                            <p>
                                <?php  include('show_add_category.php'); ?>
                            </p>
                        </div>
                        <!-- .inside -->

                    </div>
                    <!-- .postbox -->

                </div>
                <!-- .meta-box-sortables -->

            </div>
            <!-- #postbox-container-1 .postbox-container -->

        </div>
        <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div>
    <!-- #poststuff -->

    </div> <!-- .wrap -->


            

        















    
