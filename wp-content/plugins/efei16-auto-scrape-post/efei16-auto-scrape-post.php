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
//    add_action('admin_menu', 'wp_edit_admin_menus');
    add_action('admin_init', 'scrape_settings');  
    add_action('admin_init', 's3_settings'); 
}

//function wp_edit_admin_menus() {
//    global $submenu;
//
//    if (current_user_can('activate_plugins')) {
//        $submenu['wp-scraper-admin'][0][0] = 'Single Scrape';
//    }
//}

function scrape_admin_page() {
    add_menu_page('EFEI-16-Auto-Scrape-And-Post', 'EFEI-16 Auto Scrape And Post', 'activate_plugins', 'wp-scraper-admin', 'wp_scrape_single');
    //add_submenu_page('wp-scraper-admin', 'Multiple Scrape', 'Multiple Scrape', 'activate_plugins', 'wp-scraper-multiple-menu', 'wp_scrape_multiple');
    //add_submenu_page('wp-scraper-admin', 'Settings', 'Settings', 'activate_plugins', 'wp-scraper-setting-menu', 'wp_scrape_setting');
}

function scrape_settings() {
    register_setting('scrape_options', 'aws_upload_enable');
    register_setting('scrape_options', 'wp_upload_enable');
    register_setting('scrape_options', 'remove_link');
}

function s3_settings(){
     register_setting('s3_options', 's3_name');
     register_setting('s3_options', 's3_key_id');
     register_setting('s3_options', 's3_secret_key');
}

function wp_scrape_single() {
    $args = array("hide_empty" => 0,
        "type" => "post",
        "orderby" => "name",
        "order" => "ASC"
    );
    $post_categories = get_categories($args);
    
?>
        <!-- Tabs -->
                        <h2>EFEI-16 Auto Scrape And Post</h2>
                        <div id="tabs">
                                <ul>
                                        <li><a href="#scrape_one" class="title_scrape">Scrape One Article</a></li>
                                        <li><a href="#scrape_multi" class="title_scrape">Scrape All Articles in Category</a></li>
                                        <li><a href="#s3-setting" class="title_scrape">S3 Setting</a></li>
                                        <li><a href="#settings" class="title_scrape">Settings</a></li>
                                </ul>
                            <div id="scrape_one">
                                    <?php require('inc/templates/scrape_one.php'); ?>
                            </div>
                            <div id="scrape_multi">
                               <?php require('inc/templates/scrape_multi.php'); ?>
                            </div>
                            <div id="s3-setting">
                               <?php require('inc/templates/s3-setting.php'); ?>
                            </div>
                            <div id="settings">
                                <?php require('inc/templates/scrape_settings.php'); ?>
                            </div>
                        </div>

<?php
}

//function wp_scrape_multiple() {
//    require('inc/templates/scrape_multi.php');
//}
//
//function wp_scrape_setting() {
//    require('inc/templates/scrape_settings.php');
//}

add_action('admin_init', 'my_script_enqueuer');

function my_script_enqueuer() {

    wp_enqueue_script('scrape-ajax', plugin_dir_url(__FILE__) . 'scripts/scrape-ajax.js', array('jquery'));    
    wp_enqueue_style ( 'my_style', plugin_dir_url( __FILE__ ) . 'styles/style.css' );
    
    
    
                wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-progressbar' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-demo', plugin_dir_url( __FILE__ ) . 'scripts/jquery-ui-demo.js', array( 'jquery-ui-core' ) );
	
		wp_enqueue_style ( 'jquery-ui-demo', plugin_dir_url( __FILE__ ) . 'styles/jquery-ui-demo.css' );
	
		if ( 'classic' == get_user_option( 'admin_color') )
			wp_enqueue_style ( 'jquery-ui-css', plugin_dir_url( __FILE__ ) . 'styles/jquery-ui-classic.css' );
		else
			wp_enqueue_style ( 'jquery-ui-css', plugin_dir_url( __FILE__ ) . 'styles/jquery-ui-fresh.css' );
	
    
    
    
}

//Scrape Content
add_action('wp_ajax_scrape_process_one_ajax', 'scrape_process_one_ajax');

function scrape_process_one_ajax() {

    header('Access-Control-Allow-Origin: *');

    if (isset($_POST['url'])) {
        $url = $_POST['url'];
        $domain_url = str_replace('www.', '', parse_url($url, PHP_URL_HOST));
        $raw_content = file_get_contents(trim($url));
        $raw_content_filter = filter_content($raw_content, $domain_url);
       echo json_encode(array("data"=>$raw_content,"filter_content"=>$raw_content_filter));exit();
//
//        if ($post_title = scrape_process_content($url, $category_id, $content)) {
//            echo json_encode(array("data"=>$post_title));exit();
//        }
    }
    
    if(isset($_GET['content'])){
        $title = $_GET['title'];
        $content = $_GET['content'];
        $img = $_GET['img'];
        $category_id = $_GET['category_id'];
        
        $return_title = insert_to_wp($title,$content,$img, $category_id);
      
        echo json_encode(array("data"=>$return_title));exit();
    }
    
}

add_action('wp_ajax_scrape_process_multi_ajax', 'scrape_process_multi_ajax');

function scrape_process_multi_ajax() {

    header('Access-Control-Allow-Origin: *');

    if (isset($_GET['url'])) {
        $content = file_get_contents(trim($_GET['url']));        
        echo $content;
        exit();
    }
}


add_action('wp_ajax_scrape_process_multi', 'scrape_process_multi');

function scrape_process_multi(){
    if(isset($_GET['url'])){
        $url = $_GET['url'];
        $category_id = $_GET['type'];
        $content = $_GET['content'];
    }
    
    
   $title = scrape_process_content($url, $category_id, $content);
    
    echo json_encode(array("data"=>$title));exit();
}




//Insert to Wordpress 
add_action('wp_ajax_scrape_process_content', 'scrape_process_content');

function scrape_process_content($url, $category_id, $content) {

    $domain_url = str_replace('www.', '', parse_url($url, PHP_URL_HOST));


    if (!check_supported_url($domain_url)) {
        exit('Sorry, this url is not supported');
    }

    $title = scrape_post_one_article($url, $category_id, $domain_url);
    return $title;
}

function check_supported_url($url) {
    $supported_url = array('techcrunch.com', 'marrybaby.vn', 'tintucnongnghiep.com');
    if (in_array($url, $supported_url))
        return true;
    return false;
}

function scrape($url) {
    $output = file_get_contents($url);
    //$output = file_get_html($url);
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
    //echo json_encode(array('data'=>$url));exit();

    //$post_title = fetchdata($page, "<title>", "</title>");
    $post_title = fetchdata($page, "<h1 class=\"alpha tweet-title\">", "</h1>");
    echo json_encode(array('data'=>$post_title));exit();
       

   
    $post_content = filter_content($page, $domain_url);
    
   
    //echo json_encode(array("data"=>$post_content));exit();

    //Get image url    
    $image_urls = explode("<img", $post_content);


    $list_img_link = array();
    
    foreach ($image_urls as $img_link) {
        $img_links = fetchdata($img_link, "src=\"", "\"");
       
        $list_img_link[] = $img_links;
        
    }
    $list_img_link = array_filter($list_img_link);
   
    if(get_option('remove_link') == "checked"){
         $post_content = remove_link_href($post_content);
    }
    if (get_option('aws_upload_enable') == 'checked') {
        $list_s3 = upload_aws($list_img_link);
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
        

        
        if (get_option('wp_upload_enable') == 'checked') {
            //Insert Images to WP Media
            $wp_attach_image_urls = upload_wp_media($list_img_link, $post_id);
            
            $post_update_content = str_replace($list_img_link, $wp_attach_image_urls, $post_content);
            //Update Post content for changed contents
            $my_post_update = array(
                'ID' => $post_id,
                'post_content' => $post_update_content
            );
            $post_update_id = wp_update_post($my_post_update);
        }else{
            $attach_id = set_feature_image($list_img_link[1],$post_id);
            set_post_thumbnail($post_id,$attach_id);
        }
        return $post_title;
        
        
    }
}

function upload_wp_media($image_urls, $post_id) {
    
    $attach_id_urls = array();
    
    foreach ($image_urls as $image_url) {
            $attach_id_urls[] = set_feature_image($image_url, $post_id);
        }
    set_post_thumbnail($post_id, $attach_id_urls[0]);
    

    $image_attach_urls = array();
    foreach ($attach_id_urls as $attach_id_url) {
        $image_attach_urls[] = wp_get_attachment_url($attach_id_url);
    }
    return $image_attach_urls;
}

function check_url_image($image_url){
    if ($image_url != "") {
        $image_url = str_replace('%', '', $image_url);
    }
    if (strpos($image_url, '?')) {
        $image_url = substr($image_url, 0, strpos($image_url, '?'));
    }
    return $image_url;
    
}
function set_feature_image($image_url, $post_id) {
   
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $image_url = check_url_image($image_url);

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

        
        wp_update_attachment_metadata($attach_id, $attach_data);
        
        //set_post_thumbnail($post_id, $attach_id);
        return $attach_id;
        
    }
}




function upload_aws($urls) {
    require(plugin_dir_path(__FILE__) . "inc/upload_s3.php");
    $url_s3 = upload_s3($urls);
    return $url_s3;
}
 function remove_link_href($content){

     //$data = strip_tags($content, '<br>');
     $data = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $content);
    
     return $data;
     
     
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 function insert_to_wp($title,$contents,$img, $category_id) {
    
    
   
    
//    $post_title = $title;
//    $post_content = $content;
//    $list_img_link = array();
//    
//    foreach ($img as $one_img) {
//        
//       
//        $list_img_link[] = $one_img;
//        
//    }
//    $list_img_link = array_filter($list_img_link);
//   
//        
//        //Create post object
//        $my_post = array(
//            'post_title' => $title,
//            'post_content' => $content,
//            'post_status' => 'publish',
//            'post_author' => 1,
//            'tax_input' => array('category' => $category_id)
//        );
//        // Insert the post into the database
//        $post_id = wp_insert_post($my_post, true);
        

        
       
       
        
      $content =   $contents;
        
    $list_img_link = array_filter($img);
    
   
    if(get_option('remove_link') == "checked"){
         $content = remove_link_href($content);
    }
    if (get_option('aws_upload_enable') == 'checked') {
        $list_s3 = upload_aws($list_img_link);
        
        $content = str_replace($list_img_link, $list_s3, $content);
        
        //return $list_img_link;
    }




    $check_title = get_page_by_title($title, 'OBJECT', 'post');
    if (empty($check_title)) {
        //Create post object
        $my_post = array(
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
            'post_author' => 1,
            'tax_input' => array('category' => $category_id)
        );
        // Insert the post into the database
        $post_id = wp_insert_post($my_post, true);
        

        
        if (get_option('wp_upload_enable') == 'checked') {
            //Insert Images to WP Media
            $wp_attach_image_urls = upload_wp_media($list_img_link, $post_id);
            
            $post_update_content = str_replace($list_img_link, $wp_attach_image_urls, $content);
            //Update Post content for changed contents
            $my_post_update = array(
                'ID' => $post_id,
                'post_content' => $post_update_content
            );
            $post_update_id = wp_update_post($my_post_update);
        }else{
            $attach_id = set_feature_image($list_img_link[0],$post_id);
            set_post_thumbnail($post_id,$attach_id);
        }
         return $list_s3;
    }
       
        
        
        
    
}