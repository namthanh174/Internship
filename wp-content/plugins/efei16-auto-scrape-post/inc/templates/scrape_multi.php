<?php


    ?>

    <h2>Multiple Scrape</h2>

    <div class="container">
        <form action='' method='POST' id='scrape-multi-form'>

            <div><span><b>URL Category :</b></span> </div>
            <input type="text" id="url_multi" style="width:100%">

            <div><span><b>Category :</b></span></div>


            <div id="type">
                <?php
                foreach ($post_categories as $category) {
                    ?>
                    <input type='checkbox' class='type' id="<?php echo $category->cat_ID; ?>" /><label><?php echo $category->cat_name; ?></label><br />
                <?php } ?>
            </div>

            <br />
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

