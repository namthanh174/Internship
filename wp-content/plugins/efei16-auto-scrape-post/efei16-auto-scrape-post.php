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


function wp_scrape_setting(){
    $args = array("hide_empty" => 0,
        "type" => "post",
        "orderby" => "name",
        "order" => "ASC"
    );
    $post_categories = get_categories($args);
    ?>

    <h2>Settings</h2>

    <div class="container">
        <form action='' method='POST' id='scrape-setting-form'>

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


            <div><input type="submit" value="Save Changes" id="post_multi"></div>

        </form>
        <div id="wait"><img  src="<?php echo plugin_dir_url(__FILE__) . 'images/waiting.gif'; ?>"></div>
        <br />
        <div class="load"></div>

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
        
//       
//        $link = "http://localhost:8080/efei-16/wp-content/uploads/2016/09/219233_ahmed_mansoor-1.jpg";
//       
//        $links = demo($link);
//        
//        
//        print_r($links);exit();
        
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
    //$image_url = fetchdata($content, "src=\"", "\"");
   //$image_url = fetchdata($image_urls[1], "src=\"", "\"");
    
    $list_img_link = array();
    foreach($image_urls as $img_link){
        $img_links = fetchdata($img_link, "src=\"", "\"");        
        $list_img_link[] = $img_links;
        
    }
        $list_img_link = array_filter($list_img_link);
         
       // print_r($list_img_link);die();
        $list_s3 = demo($list_img_link);
        //print_r($list_s3);die();
        $image_url = $list_s3[0];
        //echo $image_url;die();
        $post_content = str_replace($list_img_link, $list_s3, $post_content);
        //$post_content = strtr($list_img_link, $list_s3, $post_content);
        
        //echo $post_content;die();
    //print_r($list_s3);exit();
    
    
    
    
    

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

        //Insert feature image

        generate_featured_image($image_url, $post_id);
    }
}

function generate_featured_image($image_url, $post_id) {

    $upload_dir = wp_upload_dir();

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

        wp_update_attachment_metadata($attach_id, $attach_data);


        set_post_thumbnail($post_id, $attach_id);
    }
}

function upload_asv($url){
       require_once(ABSPATH . 'wp-content/plugins/efei16-auto-scrape-post/inc/Aws/aws-autoloader.php');

//        use Aws\S3\S3Client;
//        use Aws\S3\Exception\S3Exception;

        $bucket = 'thanh.vo';
        $keyname = 'sample';
        // $filepath should be absolute path to a file on disk                      
        $filepath = '/path/to/image.jpg';

        // Instantiate the client.
        $s3 = S3Client::factory(array(
            'key'    => 'AKIAJ53K3XBUJTZANQ3Q',
            'secret' => '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'
        ));

        try {
            // Upload data.
            $result = $s3->putObject(array(
                'Bucket' => $bucket,
                'Key'    => $keyname,
                'SourceFile'   => $filepath,
                'ACL'    => 'public-read'
            ));



            // Print the URL to the object.
            echo $result['ObjectURL'] . "\n";
        } catch (S3Exception $e) {
            echo $e->getMessage() . "\n";
        }


}


function demo($urls){
    require(plugin_dir_path( __FILE__ )."inc/upload_s3.php");
    $url_s3 = upload_s3($urls);
    return $url_s3;
    
    
   
}





