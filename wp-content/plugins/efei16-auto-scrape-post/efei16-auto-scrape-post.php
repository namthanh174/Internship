<?php
/*
  Plugin Name:EFEI-16 Auto Scrape And Post
  Plugin URI: http://www.efe.com.vn/thanh_vo
  Description: Plugin for setting pages where admin can insert SharpSpring tracking code into a specific text field.
  Author: Thanh Vo
  Version: 1.0
  Author URI: http://www.efe.com.vn/thanh_vo
 */



if (is_admin()) {
    add_action('admin_menu', 'scrape_admin_page');
    add_action('admin_menu', 'wp_edit_admin_menus');
    add_action('admin_init','registerSettings');
}

function wp_edit_admin_menus() {
    global $submenu;

    if (current_user_can('activate_plugins')) {
        $submenu['wp-scraper-admin'][0][0] = 'Single Scrape';
    }
}

function scrape_admin_page() {

    //add_menu_page(__('Admin Scrape Ajax', 'scrape'), __('EFEI-16 Auto Scrape And Post', 'scrape'), 'manage_options', 'admin-scrape-ajax', 'scrape_render_admin');
    add_menu_page('EFEI-16-Auto-Scrape-And-Post', 'EFEI-16 Auto Scrape And Post', 'activate_plugins', 'wp-scraper-admin', 'wp_scrape_single');
    //add_submenu_page('EFEI-16 Auto Scrape And Post', 'Single Scrape', 'manage_options', __FILE__.'/single', 'scrape_render_admin');
    add_submenu_page('wp-scraper-admin', 'Multiple Scrape', 'Multiple Scrape', 'activate_plugins', 'wp-scraper-multiple-menu', 'wp_scrape_multiple');
    add_submenu_page('wp-scraper-admin', 'Settings', 'Settings', 'activate_plugins', 'wp-scraper-setting-menu', 'wp_scrape_setting');
    //add_submenu_page(__FILE__, 'About', 'About', 'manage_options', __FILE__.'/about', 'clivern_render_about_page');
}

function registerSettings(){
	    	
	    	register_setting('scrape_options','aws_upload_enable');
                register_setting('scrape_options','wp_upload_enable');
	   		}

function wp_scrape_single() {
    $args = array("hide_empty" => 0,
        "type" => "post",
        "orderby" => "name",
        "order" => "ASC"
    );
    $post_categories = get_categories($args);
    ?>

    <h2>Single Scrape</h2>

    <div class="container">
        <form action='' method='POST' id='scrape-one-form'>

            <div><span><b>URL :</b></span> </div>
            <input type="text" id="url" style="width:100%">

            <div><span><b>Category :</b></span></div>


            <div id="type">
                <?php
                foreach ($post_categories as $category) {
                    ?>
                    <input type='checkbox' class='type' id="<?php echo $category->cat_ID; ?>" /><label><?php echo $category->cat_name; ?></label><br />
                <?php } ?>
            </div>


            <div><input type="submit" value="Submit" id="post_one"></div>

        </form>
        <div id="wait"><img  src="<?php echo plugin_dir_url(__FILE__) . 'images/waiting.gif'; ?>"></div>
        <br />
        <div class="load"></div>

    </div>

    <?php
}

function wp_scrape_multiple() {
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
        <div id="wait"><img  src="<?php echo plugin_dir_url(__FILE__) . 'images/waiting.gif'; ?>"></div>
        <br />
        <div class="load"></div>

    </div>

    <?php
}

function wp_scrape_setting() {
    
    ?>

    <h2>Settings</h2>

    <div class="container">
        <form action='options.php' method='POST' id='scrape-setting-form'>
            <?php settings_fields( 'scrape_options' ); ?>
            <?php do_settings_sections('scrape_options'); ?>

            
            <input type="checkbox" name="wp_upload_enable" id="wp_upload_enable" value="checked"  <?php echo get_option('wp_upload_enable') ?>  /> Upload into WP media<br>
            <input type="checkbox" name="aws_upload_enable" id="aws_upload_enable" value="checked" <?php echo get_option('aws_upload_enable') ?> /> Upload into AWS S3 Bucket<br>
            
                
    		


            <div><input type="submit" value='<?php _e('Save Changes') ?>' id="save_setting"></div>

        </form>
        

    </div>

    <?php
}

add_action('admin_init', 'my_script_enqueuer');

function my_script_enqueuer() {

    wp_enqueue_script('scrape-ajax', plugin_dir_url(__FILE__) . 'scripts/scrape-ajax.js', array('jquery'));


    wp_register_style('my_style', plugins_url('styles/style.css', __FILE__));

    wp_enqueue_style('my_style');
}

//Scrape Content
add_action('wp_ajax_scrape_process_one_ajax', 'scrape_process_one_ajax');

function scrape_process_one_ajax() {

    header('Access-Control-Allow-Origin: *');

    if (isset($_POST['url'])) {
        $url = $_POST['url'];
        $category_id = $_POST['type'];
        $content = $_POST['content'];


        if (scrape_process_content($url, $category_id, $content)) {
            exit();
        }
    }
}

add_action('wp_ajax_scrape_process_multi_ajax', 'scrape_process_multi_ajax');

function scrape_process_multi_ajax() {

    header('Access-Control-Allow-Origin: *');

    if (isset($_POST['url'])) {
        echo file_get_contents(trim($_POST['url']));
        exit();
    }
}

//Insert to Wordpress 
add_action('wp_ajax_scrape_process_content', 'scrape_process_content');

function scrape_process_content($url, $category_id, $content) {

    $url = $_POST['url'];
    $category_id = $_POST['type'];
    $content = $_POST['content'];

    $domain_url = str_replace('www.', '', parse_url($url, PHP_URL_HOST));


    if (!check_supported_url($domain_url)) {
        exit('Sorry, this url is not supported');
    }

    scrape_post_one_article($url, $category_id, $domain_url);
}

function check_supported_url($url) {
    $supported_url = array('techcrunch.com', 'marrybaby.vn', 'tintucnongnghiep.com');
    if (in_array($url, $supported_url))
        return true;
    return false;
}

function scrape($url) {
    $output = file_get_contents($url);
    return $output;
}

function fetchdata($data, $start, $end) {
    $data = stristr($data, $start); // Stripping all data from before $start
    $data = substr($data, strlen($start));  // Stripping $start
    $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
    $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
    return $data;   // Returning the scraped data from the function
}

function filter_content($page, $domain_url) {

    if ($domain_url == 'techcrunch.com') {

        $start = "<div class=\"article-entry text\">";
        $end = "<div id=\"social-after-wrapper\"";
        //return $page;
    }
    if ($domain_url == 'marrybaby.vn') {
        $start = "<div class=\"article-details-content-details\">";
        $end = "<div class=\"article-footer-block item-clear-float\">";
    }
    if ($domain_url == 'tintucnongnghiep.com') {
        $start = "itemprop='description articleBody'>";
        $end = "<center>";
    }
    $content = fetchdata($page, $start, $end);

    return $content;
}

function scrape_post_one_article($url, $category_id, $domain_url) {

    $page = scrape($url);

    $post_title = fetchdata($page, "<title>", "</title>");


    $post_content = filter_content($page, $domain_url);

    //Get image url    
    $image_urls = explode("<img", $post_content);


    $list_img_link = array();
    foreach ($image_urls as $img_link) {
        $img_links = fetchdata($img_link, "src=\"", "\"");
        $list_img_link[] = $img_links;
    }
    $list_img_link = array_filter($list_img_link);
    
    	if(get_option('aws_upload_enable') == 'checked'){
               $list_s3 = upload_aws($list_img_link);

               $image_url = $list_s3[0];

               $post_content = str_replace($list_img_link, $list_s3, $post_content);
		   }
   



    $check_title = get_page_by_title($post_title, 'OBJECT', 'post');
    if (empty($check_title)) {
        //Create post object
        $my_post = array(
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'tax_input' => array('category' => $category_id)
        );
        // Insert the post into the database
        $post_id = wp_insert_post($my_post, true);
        
        
        //Insert Images to WP Media
        $wp_attach_image_urls = upload_wp_media($list_img_link,$post_id);
        if(get_option('wp_upload_enable') == 'checked'){
            $post_update_content = str_replace($list_img_link, $wp_attach_image_urls, $post_content);
            //Update Post content for changed contents
            $my_post_update = array(
                'ID' =>  $post_id,
                'post_content' => $post_update_content

            );
            $post_update_id = wp_update_post($my_post_update);
        }
        
        
        
    }
}



function upload_wp_media($image_urls,$post_id){
    $upload_dir = wp_upload_dir();
    $num = 0;
    $attach_id_urls = array();
    foreach($image_urls as $image_url){
           $image_data = file_get_contents($image_url);
            if ($image_url != "") {
                $image_url = str_replace('%', '', $image_url);
            }
            if (strpos($image_url, '?')) {
                $image_url = substr($image_url, 0, strpos($image_url, '?'));
            }


            $filename = basename($image_url);


            $valid_image_types = array('gif', 'jpeg', 'png', 'jpg');
            $wp_filetype = wp_check_filetype($filename, null);



            if (in_array($wp_filetype["ext"], $valid_image_types)) {

                if (wp_mkdir_p($upload_dir['path']))
                    $file = $upload_dir['path'] . '/' . $filename;
                else
                    $file = $upload_dir['basedir'] . '/' . $filename;
                file_put_contents($file, $image_data);
                
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title' => sanitize_file_name($filename),
                    'post_content' => '',
                    'post_status' => 'inherit',
                );
                $attach_id = wp_insert_attachment($attachment, $file, $post_id);
                require_once(ABSPATH . 'wp-admin/includes/image.php');


                $attach_data = wp_generate_attachment_metadata($attach_id, $file);
                
                $attach_id_urls[] = $attach_id;
                wp_update_attachment_metadata($attach_id, $attach_data);
                $num++;
                
                  //Insert feature image
                if($num == 1){
                    set_post_thumbnail($post_id, $attach_id);
                }
            }
                
    }
    
        $image_attach_urls = array();
        foreach($attach_id_urls as $attach_id_url){
            $image_attach_urls[] = wp_get_attachment_url($attach_id_url);

        }
        return $image_attach_urls;
    
    

       
}

function upload_aws($urls) {
    require(plugin_dir_path(__FILE__) . "inc/upload_s3.php");
    $url_s3 = upload_s3($urls);
    return $url_s3;
}
