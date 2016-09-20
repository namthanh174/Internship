<?php

$args = array("hide_empty" => 0,
        "type" => "post",
        "orderby" => "name",
        "order" => "ASC"
    );
    $post_categories = get_categories($args);
    ?>

    <h2>Multiple Scrape</h2>

    <div class="container">
        <form action='' method='POST' id='scrape-multi-form'>

            <div><span><b>URL Category :</b></span> </div>
            <input type="text" id="url" style="width:100%">

            <div><span><b>Category :</b></span></div>


            <div id="type">
                <?php
                foreach ($post_categories as $category) {
                    ?>
                    <input type='checkbox' class='type' id="<?php echo $category->cat_ID; ?>" /><label><?php echo $category->cat_name; ?></label><br />
                <?php } ?>
            </div>


            <div><input type="submit" value="Submit" id="post_multi"></div>

        </form>
        <div id="wait"><img  src="<?php echo plugin_dir_url(__FILE__) . '../../images/waiting.gif'; ?>"></div>
        <br />
        <div class="load"></div>

    </div>

