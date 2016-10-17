<?php
/*
  Plugin Name:E-Scraper
  Plugin URI: http://www.efe.com.vn/thanh_vo
  Description: Plugin for setting pages where admin can insert SharpSpring tracking code into a specific text field.
  Author: Thanh Vo
  Version: 1.0
  Author URI: http://www.efe.com.vn/thanh_vo
 */






/*
 * ACTIVE PLUGIN
 */

function scrape_activate() {
    // add_option('upload_enable', '', '', 'yes');
    // add_option('remove_link', '', '', 'yes');
    add_option('s3_name', '', '', 'yes');
    add_option('s3_key_id', '', '', 'yes');
    add_option('s3_secret_key', '', '', 'yes');
    add_option('license', '', '', 'yes');
    add_option('secret_key', '', '', 'yes');
    add_option('isProVersion', '', '', 'yes');
}

register_activation_hook(__FILE__, 'scrape_activate');




//----CREATE PATTERN TABLE  -------------/
// global $jal_db_version;
// $jal_db_version = '1.0';

// function scrape_pattern_table() {
//     global $wpdb;
//     global $jal_db_version;

//     $table_name = $wpdb->prefix . 'scrape_pattern';

//     $charset_collate = $wpdb->get_charset_collate();

//     $sql = "CREATE TABLE $table_name (
// 		id mediumint(9) NOT NULL AUTO_INCREMENT,
// 		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
// 		define_title varchar(255) NOT NULL,
//         define_content text NOT NULL,
//         parent_node text NOT NULL,   
//         define_category text,		
// 		define_url varchar(255) DEFAULT '' NOT NULL,
// 		PRIMARY KEY  (id)
// 	) $charset_collate;";

//     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//     dbDelta($sql);

//     add_option('jal_db_version', $jal_db_version);
// }

// register_activation_hook(__FILE__, 'scrape_pattern_table');
//----  END  -------------/


//Set session for Pro Version of Plugin

add_action('init','register_session');
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');


function register_session(){
    if( !session_id() )
        session_start();

    if(get_option('license') != null && get_option('secret_key') != null ){
       
        
        $data = array('license'=>get_option('license'),
            'secret_key'=>get_option('secret_key'),
            'domain'=> $_SERVER['HTTP_HOST']
            );

            $data_string = json_encode($data);

            $token = create_token($data);
             $_SESSION['token'] = $token;
            $_SESSION['license'] = get_option('license');
        // if(check_license_api($data) == 'true'){
        //     $_SESSION['license'] = get_option('license');
        // }
    }
}

    add_action('wp_ajax_check_api', 'check_api');
    function check_api(){

        //echo $_SESSION['token'];exit();
         $data = array('license'=>get_option('license'),
            'secret_key'=>get_option('secret_key'),
            'domain'=> $_SERVER['HTTP_HOST']
            );
            
            
             $data_string = json_encode(array('token'=>$_SESSION['token'],'license'=>get_option('license')));

            // $api_url = 'efe.com.vn/thanh_vo/api-db/check_license_api.php/escraper_license/'.$license;
            // $result = CallAPI('POST', $api_url, $data_string );


         $api_url = 'efe.com.vn/thanh_vo/api-db/s3_setting.php/escraper_license/'.$license;
         $result = CallAPI('POST', $api_url, $data_string );
            if($result === false){
                echo 'success';exit();
            }
           
             print_r($result);exit();

    }



function myEndSession() {
    $_SESSION['token'] = '';
    session_destroy();
}




//Delete license
add_action('wp_ajax_check_session', 'check_session');
function check_session(){
   if(isset($_SESSION['license'])){
    echo 'completed';exit();
   }


    
}




function create_token($data){
        $data_string = json_encode($data);

        $api_url = 'efe.com.vn/thanh_vo/api-db/create_token.php/escraper_license/';
        $result = CallAPI('POST', $api_url, $data_string );
        return $result;
    
}

 



function check_license_api($data){
     
        $data_string = json_encode($data);

        $api_url = 'efe.com.vn/thanh_vo/api-db/check_license_api.php/escraper_license/'.$license;
        $result = CallAPI('POST', $api_url, $data_string );
        return $result;
}





add_action('wp_ajax_check_license_ajax', 'check_license_ajax');
function check_license_ajax(){
    if(isset($_POST['license'])){
        $license = $_POST['license'];
        $secret_key = $_POST['secret_key'];
        $domain = $_POST['domain_register'];

        $data = array('license'=>$license,
                       'secret_key' => $secret_key,
                       'domain' => $domain);



        $data_string = json_encode($data);

        $api_url = 'efe.com.vn/thanh_vo/api-db/license_api.php/escraper_license/'.$license;
        $result = CallAPI('POST', $api_url, $data_string );


        
        // if($result == null){
        //     echo "Error";exit();
        // }
        // $result = json_decode($result);

        // //Get title pattern from database
        // $server_secret_key = $result->secret_key;   
        // echo json_encode(array('data'=>$result));exit();
        
        if($result == 'true'){
             $_SESSION['token'] = create_token($data);
            update_option('isProVersion','true');
            $option = get_option('license');
            echo json_encode(array('data'=>$data_string,'option'=>$option));exit();
        }else{
            echo json_encode(array('error'=>'License in valid'));exit();
        }










        echo json_encode(array('check'=>$result));exit();
    }
}


//Delete license
add_action('wp_ajax_delete_license', 'delete_license');
function delete_license(){
    // delete_option('license', '', '', 'yes');
    // delete_option('secret_key', '', '', 'yes');
    update_option('license', '');
    update_option('secret_key', '');
    update_option('isProVersion', '');
    $_SESSION['token'] = '';

    echo 'completed';exit();
}

















//Insert pattern of Url to Database
add_action('wp_ajax_insert_scrape_pattern_table', 'insert_scrape_pattern_table');

function insert_scrape_pattern_table() {
    // global $wpdb;

    if (isset($_POST['define_url'])) {
        $define_url = $_POST['define_url'];
        $define_title = $_POST['define_title'];
        $define_content = $_POST['define_content'];
        $parent_node = $_POST['define_parent_node'];
    }



     $data = array( 
                        'time' => current_time('mysql'),
                        'define_title' => $define_title,
                        'define_content' => $define_content,
                        'parent_node' => $parent_node,
                        'define_category' => '',
                        'define_url' => $define_url,
                            
                    );

        $data_string = json_encode($data);

        $url_api = 'efe.com.vn/thanh_vo/api-db/api.php/escraper_scrape_pattern';
        $result = CallAPI('POST', $url_api, $data_string);

        if($result)
        {
            echo "Success. Insert pattern has been successed";
            exit();
        } else {
            echo "Error. Insert pattern has been Error";
            exit();
        }














    // $table_name = $wpdb->prefix . 'scrape_pattern';    
    // if ($wpdb->insert(
    //                     $table_name, array(
    //                     'time' => current_time('mysql'),
    //                     'define_title' => $define_title,
    //                     'define_content' => $define_content,
    //                     'parent_node' => $parent_node,
    //                     'define_category' => '',
    //                     'define_url' => $define_url,
    //                         )
    //                 )
    //     ) {
    //     echo "Success. Insert pattern has been successed";
    //     exit();
    // } else {
    //     echo "Error. Insert pattern has been Error";
    //     exit();
    // }


   


}

/*
 * DEACTIVE PLUGIN
 */

function scrape_deactivate() {
    // delete_option('upload_enable', '', '', 'yes');
    // delete_option('remove_link', '', '', 'yes');
    delete_option('s3_name', '', '', 'yes');
    delete_option('s3_key_id', '', '', 'yes');
    delete_option('s3_secret_key', '', '', 'yes');
}

register_deactivation_hook(__FILE__, 'scrape_deactivate');





//Settings


if (is_admin()) {
    add_action('admin_menu', 'scrape_admin_page');
    // add_action('admin_init', 'scrape_settings');
    add_action('admin_init', 's3_settings');
    add_action('admin_init', 'license_pro_settings');
}

function scrape_admin_page() {
    add_menu_page('E-Scraper', 'E-Scraper', 'activate_plugins', 'wp-scraper-admin', 'wp_scrape_layout');
}

// function scrape_settings() {
//     register_setting('scrape_options', 'upload_enable');
//     register_setting('scrape_options', 'remove_link');
// }

function s3_settings() {
    register_setting('s3_options', 's3_name');
    register_setting('s3_options', 's3_key_id');
    register_setting('s3_options', 's3_secret_key');
}

function license_pro_settings(){
    register_setting('license_pro_options', 'license');
    register_setting('license_pro_options', 'secret_key');
    register_setting('license_pro_options','isProVersion');
}

function wp_scrape_layout() {

    if(get_option('isProVersion') != 'true'){
         $choose_category = 'disabled';
        $choose_aws_s3 = 'disabled';
        $choose_s3_setting = 'hidden';

    }

    $args = array("hide_empty" => 0,
        "type" => "post",
        "orderby" => "name",
        "order" => "ASC"
    );


    $post_categories = get_categories($args);
    
    ?>
    <!-- Tabs -->
    <h2>E-Scraper</h2>
    <div id="tabs">
        <ul>
            <li><a href="#scrape_one" class="title_scrape">Scrape And Post</a></li>
            <li><a href="#define_pattern" class="title_scrape">Define The Pattern From URL</a></li>
            <li><a href="#s3-setting" id='s3_setting' class="title_scrape" <?php echo $choose_s3_setting; ?> >S3 Setting</a></li>
            <!-- <li><a href="#settings" class="title_scrape">Settings</a></li> -->
            <li><a href="#up_pro" class="title_scrape">Upgrade to PRO Version</a></li>
        </ul>
        <div id="scrape_one">
    <?php require('inc/templates/scrape_one.php'); ?>
        </div>
        <div id="define_pattern">
    <?php require('inc/templates/define_pattern.php'); ?>
        </div>
        <div id="s3-setting">
    <?php require('inc/templates/s3-setting.php'); ?>
        </div>
        <!-- <div id="settings">
    <?php  //require('inc/templates/scrape_settings.php'); ?>
        </div> -->
        <div id="up_pro">
    <?php require('inc/templates/upgrade_pro.php'); ?>
        </div>
    </div>

    <?php
}

add_action('admin_init', 'my_script_enqueuer');

function my_script_enqueuer() {
    //Enqueue my JS
    wp_enqueue_script('main-js', plugin_dir_url(__FILE__) . 'scripts/main.js', array('jquery'));

   
    wp_enqueue_script('scrape-content', plugin_dir_url(__FILE__) . 'scripts/scrape-content.js', array('jquery'));
  
    wp_enqueue_script('define-pattern-ajax', plugin_dir_url(__FILE__) . 'scripts/define-pattern-ajax.js', array('jquery'));
    wp_enqueue_script('settings-ajax', plugin_dir_url(__FILE__) . 'scripts/settings-ajax.js', array('jquery'));
    wp_enqueue_script('scrape-ajax', plugin_dir_url(__FILE__) . 'scripts/scrape-ajax.js', array('jquery'));


    //Enqueue wordpress Jquery   
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_script('jquery-ui-autocomplete');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_script('jquery-ui-progressbar');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('jquery-ui-tabs');
   

    //Enqueue CSS
    wp_enqueue_style('my_style', plugin_dir_url(__FILE__) . 'styles/style.css');    
    if ('classic' == get_user_option('admin_color'))
        wp_enqueue_style('jquery-ui-css', plugin_dir_url(__FILE__) . 'styles/jquery-ui-classic.css');
    else
        wp_enqueue_style('jquery-ui-css', plugin_dir_url(__FILE__) . 'styles/jquery-ui-fresh.css');
}

//End setting





//Scrape Content


//Insert to Wordpress 


function check_supported_url($url) {

    $api_url = 'efe.com.vn/thanh_vo/api-db/api.php/escraper_scrape_pattern/'.$url;
        $result = CallAPI('GET', $api_url, $data = false);
        if($result)
                return true;
            return false; 

    // global $wpdb;
    // $table_name = $wpdb->prefix . 'scrape_pattern';
    
    // $query = $wpdb->prepare("SELECT count(define_url) FROM `".$table_name."` WHERE define_url ='".$url."'");
    // $result = $wpdb->get_var($query);
    // if($result > 0)
    //     return true;
    // return false; 



       
    
}








function url_get_contents ($url) {

    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_ENCODING , "gzip");
        $source = curl_exec($ch);
     
    
        if($source == false){
                $curlConfig = array(
                    CURLOPT_URL            => $url,
                    CURLOPT_POST           => 1,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_COOKIEFILE => 'cookies.txt',
                    CURLOPT_COOKIEJAR => 'cookies.txt',
                    CURLOPT_USERAGENT => '"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"',
                    CURLOPT_FOLLOWLOCATION => 1,
                    CURLOPT_REFERER => $url
                    );
                curl_setopt_array($ch, $curlConfig);
                $source = curl_exec($ch);

        
         } 


    
    
        if($source == false){
            $source = file_get_contents($url);
        }

         curl_close($ch);
    
    



    return $source;
}















//SCRAPE ONE CONTENT

add_action('wp_ajax_scrape_raw_content_ajax', 'scrape_raw_content_ajax');

function scrape_raw_content_ajax() {
    header('Access-Control-Allow-Origin: *');
    
    if (isset($_GET['url'])) { 
        $url = trim($_GET['url']); 
        $scrape_category = $_GET['scrape_category']; 
        $define_url = $_GET['define_url'];
        
        $content = url_get_contents($url);
        // echo json_encode(array('token'=>$_SESSION['token']));exit();
        if($content == false){
            echo 'error';exit();
        }
       

        if($scrape_category == 1){
            $pattern_category = get_define_category($define_url);
            if($pattern_category == false){
                echo false;exit();
            }
            echo json_encode(array('content'=>$content,'pattern_category'=>$pattern_category));
            exit();

        }

        echo $content;exit();
        
        
    }
}



function get_define_category($define_url){

            $data = array('license'=>get_option('license'),
                        'token'=>$_SESSION['token'],
                        'define_url' => $define_url
                );
            $data_string = json_encode($data);

            $api_url = 'efe.com.vn/thanh_vo/api-db/get_define_category.php';        
            $pattern_category = CallAPI('POST', $api_url, $data_string );
            if($pattern_category == 'error'){
                return false;
            }


             preg_match('/(?P<name>\w+).(?P<class>(.*))/', $pattern_category, $content_pattern_matches);
            $category_pattern_tagName =  strtolower($content_pattern_matches['name']);
            $category_pattern_className = strtolower($content_pattern_matches['class']); 
            return array('category_tag'=>$category_pattern_tagName,'category_class'=>$category_pattern_className);
}




add_action('wp_ajax_scrape_content_ajax', 'scrape_content_ajax');

function scrape_content_ajax() {
    header('Access-Control-Allow-Origin: *');
    

    if (isset($_GET['url'])) {        
        //$content = url_get_contents(trim($_GET['url']));
        $url = $_GET['url'];    
        //$domain_url = str_replace('www.', '', parse_url($url, PHP_URL_HOST));

        
        if (!check_supported_url($url)){
            //echo json_encode(array('check_url'=>0,'url'=>$url));exit();
            echo json_encode(array('check_url'=>0));exit();
        }



    // global $wpdb;
    // $table_name = $wpdb->prefix . 'scrape_pattern';
    // $query = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE define_url ='".$url."'");
    // $result = $wpdb->get_row($query,ARRAY_A);



        $api_url = 'efe.com.vn/thanh_vo/api-db/api.php/escraper_scrape_pattern/'.$url;
        $result = CallAPI('GET', $api_url, $data = false);
        $result = json_decode($result);

    //Get title pattern from database
    $title_pattern = $result->define_title;   
    preg_match('/(?P<name>\w+).(?P<class>(.*))/', $title_pattern, $title_pattern_matches);
    $title_pattern_tagName =  strtolower($title_pattern_matches['name']);
    $title_pattern_className = strtolower($title_pattern_matches['class']);

   
    //get content pattern from database
    $content_pattern = $result->define_content;    
    preg_match('/(?P<name>\w+).(?P<class>(.*))/', $content_pattern, $content_pattern_matches);
    $content_pattern_tagName =  strtolower($content_pattern_matches['name']);
    $content_pattern_className = strtolower($content_pattern_matches['class']);  
    //get parent pattern from database
    $parent_pattern = $result->parent_node;    
    preg_match('/(?P<name>\w+).(?P<class>(.*))/', $parent_pattern, $parent_pattern_matches);
    $parent_pattern_tagName =  strtolower($parent_pattern_matches['name']);
    $parent_pattern_className = strtolower($parent_pattern_matches['class']);   
 

    

    echo json_encode(array('check_url'=>1,
        'title_tagName'=>$title_pattern_tagName,'title_className'=>$title_pattern_className,
        'content_tagName'=> $content_pattern_tagName,'content_className'=>$content_pattern_className,
        'parent_tagName'=> $parent_pattern_tagName,'parent_className'=>$parent_pattern_className));
        exit();
    }
}













// DEFINE PATTERN AND INSERT TO WP POST DEMO . CONTENT FILER BY JAVASCRIPT


add_action('wp_ajax_scrape_post_content_ajax', 'scrape_post_content_ajax');


function scrape_post_content_ajax(){
    $page = $_POST['content'];
    $domain_url = $_POST['define_url'];
    $post_title = $_POST['title'];
    $category_id = $_POST['type'];
    $post_status = $_POST['post_status'];
    $choose_upload_img = $_POST['choose_upload_img'];
    $remove_link  = $_POST['remove_link'];


    $post_content = $page;


    $image_urls = $_POST['img'];

    
    $list_img_link = array_filter($image_urls);

    if ($remove_link == "checked") {
        $post_content = remove_link_href($post_content);
    }
    //Upload Image to AWS S3 Amazon
    if ($choose_upload_img == 'aws_upload_enable') {
         // require(plugin_dir_path(__FILE__) . "inc/upload_s3.php");
         // $list_s3 = upload_s3($list_img_link);
            // 'secret_key'=>get_option('secret_key'),
            // 'domain'=> $_SERVER['HTTP_HOST'],

        $key_s3 = trim(get_option('s3_key_id'));    
        $secret = trim(get_option('s3_secret_key'));
        $bucket_name = trim(get_option('s3_name'));
        $data = array('license'=>get_option('license'),
            'token'=>$_SESSION['token'],
            'list_images'=>$list_img_link,
            'key_s3'=>$key_s3,
            'secret'=>$secret,
            'bucket_name'=>$bucket_name
            );
        $data_string = json_encode($data);

        $api_url = 'efe.com.vn/thanh_vo/api-db/s3_setting.php/escraper_license/'.$license;        
        $list_s3 = CallAPI('POST', $api_url, $data_string );
        $list_s3 = json_decode($list_s3);
        // print_r($list_s3);exit();
        
        $post_content = str_replace("amp;", "", $post_content);
        $post_content = str_replace($list_img_link, $list_s3, $post_content);

        
    }

    //Insert Post
    $check_title = get_page_by_title($post_title, 'OBJECT', 'post');
    if (empty($check_title)) {
        //Create post object
        $my_post = array(
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_status' => $post_status,
            'post_author' => 1,
            'tax_input' => array('category' => $category_id)
        );
        // Insert the post into the database
        $post_id = wp_insert_post($my_post, true);


        //Upload to Wordpress media

        if ($choose_upload_img == 'wp_upload_enable') {
            //Insert Images to WP Media
            $wp_attach_image_urls = upload_wp_media($list_img_link, $post_id);

            $post_update_content = str_replace($list_img_link, $wp_attach_image_urls, $post_content);
            //Update Post content for changed contents
            $my_post_update = array(
                'ID' => $post_id,
                'post_content' => $post_update_content
            );
            $post_update_id = wp_update_post($my_post_update);
        } else {
            // $image_url_feature = '';
            // $num = 0;
            // while(true){
            //     if($list_img_link[$num] != null ){
            //         $image_url_feature = $list_img_link[$num];
            //         break;
            //     }
            //     $num +=1;
            // }
             
            $attach_id = set_feature_image($list_img_link[0], $post_id);
            set_post_thumbnail($post_id, $attach_id);
        }
        //return $post_title;

        echo json_encode(array("post_id"=>$post_id,'title'=>$post_title));exit();
    }
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

function check_url_image($image_url) {
    if (strpos($image_url, '%')) {
        $image_url = str_replace('%', '', $image_url);
    }
    if (strpos($image_url, '?')) {
        $image_url = substr($image_url, 0, strpos($image_url, '?'));
    }
    return $image_url;
}






//Remove url From the post
function remove_link_href($content) {
    $data = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $content);

    return $data;
}


//Add Category to Wordpress

add_action('wp_ajax_add_category_ajax', 'add_category_ajax');

function add_category_ajax() {
    if(isset($_POST['name_cat'])){
        $cat_name = $_POST['name_cat'];
        $cat_parent = $_POST['parent_cat'];

        if($cat_id = wp_create_category($cat_name,$cat_parent)){
            echo $cat_id;exit();
        }
        echo "error";exit();
    }
    

}










function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  


    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
