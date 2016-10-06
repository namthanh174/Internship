








<?php


//    $args = array("hide_empty" => 0,
//        "type" => "post",
//        "orderby" => "name",
//        "order" => "ASC"
//    );
//    $post_categories = get_categories($args);
    ?>

    <!-- <h2>Single Scrape</h2> -->

    <div class="container">
        <form action='' method='POST' id='scrape-one-form'>

           <table class="form-table">
           <tr> <th width="150"><h4><?php esc_attr_e( 'URL: ', 'wp_admin_style' ); ?></h4></th>
            <td><input type="text" id="url_one" style="width:100%"></td>
            </tr>
            
            <tr>
               <th><h4><?php esc_attr_e( 'Choose Scrape :', 'wp_admin_style' ); ?></h4></th>

            
             <!-- <h3>Choose Post Status</h3> -->
            <td>        
                <input type="radio" name="choose_scrape" id="choose_one_aritcle" class="choose_one_aritcle" value="one" checked="checked" />Scrape one article &nbsp;
                <input type="radio" name="choose_scrape" id="choose_category" class="choose_category" value="multi" /> Scrape category
            
            </td>
            
            </tr>


            <tr>
            <th><h4><?php esc_attr_e( 'Category :', 'wp_admin_style' ); ?></h4></th>

                
                <td>
                    <?php  include('show_add_category.php'); ?>
                </td>
            </tr>
            <tr>
               <th><h4><?php esc_attr_e( 'Choose Post Status :', 'wp_admin_style' ); ?></h4></th>

            
             <!-- <h3>Choose Post Status</h3> -->
            <td>        
                <input type="radio" name="choose_status" class="choose_draft" value="draft" checked="checked" /> Draft &nbsp;
                <input type="radio" name="choose_status" class="choose_publish" value="publish" /> Published<br>
                
            
            </td>
            
            </tr>

            </table>
            <input class="button-primary" type="submit" id="post_one" name="post_one" value="<?php esc_attr_e( 'Submit' ); ?>" />

        </form>
        <br />
         <div class="result1"></div>
        <div id="wait1"><img  src="<?php echo plugin_dir_url(__FILE__) . '../../images/waiting.gif'; ?>"></div>
       
        <br />
        <div class="load1"></div>
        <!--<div id="prog"></div>-->
        	
<!--        <div id="progress-wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
        <div id="output"> error or success results </div>
        
        <progress id="progress" value="0"></progress>
        <span id="display"></span>-->

    </div>

    
