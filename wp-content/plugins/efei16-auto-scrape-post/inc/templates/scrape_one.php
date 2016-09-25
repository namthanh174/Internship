



<!-- Tabs -->
<!--		<h2>Tabs</h2>
		<div id="tabs">
			<ul>
				<li><a href="#scrape">Scrape</a></li>
				<li><a href="#s3-setting">S3 Setting</a></li>
				<li><a href="#settings">Settings</a></li>
			</ul>
                    <div id="scrape">
                        
                    </div>
                    <div id="s3-setting">
                        
                    </div>
                    <div id="settings">
                        
                    </div>
                </div>-->






<?php


//    $args = array("hide_empty" => 0,
//        "type" => "post",
//        "orderby" => "name",
//        "order" => "ASC"
//    );
//    $post_categories = get_categories($args);
    ?>

    <h2>Single Scrape</h2>

    <div class="container">
        <form action='' method='POST' id='scrape-one-form'>

            <div><span><b>URL :</b></span> </div>
            <input type="text" id="url_one" style="width:100%">

            <div><span><b>Category :</b></span></div>


            <div id="type">
                <?php
                foreach ($post_categories as $category) {
                    ?>
                    <input type='checkbox' class='type' id="<?php echo $category->cat_ID; ?>" /><label><?php echo $category->cat_name; ?></label><br />
                <?php } ?>
            </div>
            


            <br />
            <input class="button-primary" type="submit" id="post_one" name="post_one" value="<?php esc_attr_e( 'Submit' ); ?>" />

        </form>
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

    
