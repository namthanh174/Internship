<?php 
    /*
    Plugin Name:EFEI-16 Auto Scrape And Post 
    Plugin URI: http://www.efe.com.vn/thanh_vo
    Description: Plugin for setting pages where admin can insert SharpSpring tracking code into a specific text field.
    Author: Thanh Vo
    Version: 1.0
    Author URI: http://www.efe.com.vn/thanh_vo
    */


    function scrape_admin_page(){
          global $scrape_settings;
          $scrape_settings = add_menu_page(__('Admin Scrape Ajax','scrape'),__('EFEI-16 Auto Scrape And Post','scrape'),'manage_options','admin-scrape-ajax','scrape_render_admin');
    }

    add_action('admin_menu','scrape_admin_page');

    function scrape_render_admin(){
            $args = array("hide_empty" => 0,
                          "type"      => "post", 
                          "orderby"   => "name",
                          "order"     => "ASC" 
                          );
            $post_categories = get_categories($args);
                                                  
                  ?>
                  <h2>Auto Scrape And Post</h2>

                  <div class="container">
                        <form action='' method='POST' id='scrape-form'>
                                  
                                  <div><span><b>URL :</b></span> </div>
                                  <input type="text" id="url" style="width:100%">

                                  <div><span><b>News's Category :</b></span></div>
                                         

                                    <div id="type">
                                     <?php
                                      foreach ( $post_categories  as $category )

                                       { ?>
                                      <input type='checkbox' class='type' id="<?php echo $category->cat_ID; ?>" /><label><?php echo $category->cat_name; ?></label><br />
                                      <?php }?>
                                    </div>
                                   
                                  
                                  <div><input type="submit" value="Submit" id="getresult"></div>
                            
                          </form>
                      <div id="wait"><img  src="<?php echo plugin_dir_url(__FILE__).'images/waiting.gif'; ?>"></div>
                      <br />
                      <div class="load"></div>

                  </div>

                  <?php 
           
          
            
    }





    add_action( 'admin_init', 'my_script_enqueuer' );

    function my_script_enqueuer() {

    wp_enqueue_script('scrape-ajax',plugin_dir_url(__FILE__).'scripts/scrape-ajax.js',array('jquery'));

    wp_register_style('my_style', plugins_url('styles/style.css',__FILE__ ));
   
    wp_enqueue_style('my_style');


    }


    function scrape_process_ajax(){
              $url = $_POST['url'];
              
              $category_id = $_POST['type'] ;

              if(!filter_var($url, FILTER_VALIDATE_URL) === true) {
                json_encode(array('error'=>'invalid_url'));

                die();
              }else {
                
                $domain_url = str_replace('www.','',parse_url($url, PHP_URL_HOST));
              
               
                
              if(!check_supported_url($domain_url)){
                exit('Sorry, this url is not supported');
              }
              //$content = scrape($url);
              

              $list_article_urls = check_category($domain_url,$url);
             // $list_article_urls =  array_filter(check_category($domain_url,$url));
             //  echo "<pre>";
             //  var_dump($list_article_urls);exit();
             //  echo "</pre>";
              if(is_array($list_article_urls)){
                $list_article_urls =  array_filter($list_article_urls);
                $number = 0;
                foreach($list_article_urls as $article_url)
                {
                  scrape_post_one_article($article_url,$category_id,$domain_url);
                  $number++;
                }
                echo $number;
                exit();
                
              }


            scrape_post_one_article($list_article_urls,$category_id,$domain_url);
                
              
              
              //scrape_post_one_article($list_article_urls,$category_id,$domain_url);
              
              //scrape_post_one_article($url,$category_id,$domain_url);

              echo "Completed";
               exit();
              
              
               
        }
    }

    add_action('wp_ajax_scrape_process_ajax','scrape_process_ajax');
    




    function scrape($url){
            $output = file_get_contents($url); 
            return $output;
    }

    function fetchdata($data, $start, $end){
          $data = stristr($data, $start); // Stripping all data from before $start
          $data = substr($data, strlen($start));  // Stripping $start
          $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
          $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
          return $data;   // Returning the scraped data from the function
    }


    function filter_content($page,$domain_url){

        if($domain_url == 'techcrunch.com')
        {
          
          $start = "<div class=\"article-entry text\">";
          $end = "<div id=\"social-after-wrapper\" class=\"cf social-share social-share-inline\">";  
        }
        if($domain_url == 'marrybaby.vn')
        {
          $start = "<div class=\"article-details-content-details\">";
          $end = "<div class=\"article-footer-block item-clear-float\">";
        }
       if($domain_url == 'tintucnongnghiep.com')
        {
          $start ="itemprop='description articleBody'>";
          $end = "<center>";
        }
       
        return fetchdata($page,$start,$end);
    }



  function check_supported_url($url){
      $supported_url = array('techcrunch.com','marrybaby.vn','tintucnongnghiep.com');
      if(in_array($url,$supported_url))
        return true;
      return false;
  }


  function check_category($domain_url,$url){
      $content = scrape($url);
     
      if(($domain_url == 'techcrunch.com') && (strpos($content, "<h1 class=\"cat-tag-title\">") !== false))
        {
          $result = fetchdata($content, "<ul class=\"river\">", "<div class=\"river-nav\">");
          $urls = explode("<div class=\"block-content",$result);

          foreach($urls as $url) {
            $list_url[] = fetchdata($url, "<h2 class=\"post-title\"><a href=\"", "\"");
          }

          //$list_url[] = fetchdata($content, "<h2 class=\"post-title\"><a href=\"", "\"");  
           
          return $list_url;
        }else if(($domain_url == 'marrybaby.vn') &&(strpos($content, "<div class=\"category-level2-lcol f-left\">") !== false))
        {
         
          $result = fetchdata($content, "<ul class=\"category-article-list\">", "<div class=\"category-level2-rcol f-right\">");
          $urls = explode("<div class=\"item-clear-float",$result);

          foreach($urls as $url) {
            $list_url[] = fetchdata($url, "<a href=\"", "\"");
          }
           
          return $list_url;
          
        }else if(($domain_url == 'tintucnongnghiep.com') &&(strpos($content,"<div class='menu_label'>") !== false))
        {
          $result = fetchdata($content, "<div id='singlepage'>", "<div id='sidebar'>");
          $urls = explode("<article class='item-list'",$result);

          foreach($urls as $url) {
            $list_url[] = fetchdata($url, "<a href='","'");
          }
           
          return $list_url;
          
        }else{
          return $url;
        }

        

  }





  function scrape_post_one_article($url,$category_id,$domain_url){

                $page = scrape($url);

                $title = fetchdata($page,"<title>", "</title>");

                if (!get_page_by_title($title, 'OBJECT', 'post') ){

                $content = filter_content($page,$domain_url);


                //Get image url
                $image_url = explode($content,"<img");
                $image_url = fetchdata($content, "src=\"", "\"");

                //Create post object
                $my_post = array(
                  'post_title'    => $title ,
                  'post_content'  => $content,
                  'post_status'   => 'publish',
                  'post_author'   => 1,
                  'tax_input' => array( 'category' => $category_id) 
                  
                );
                // Insert the post into the database
                $post_id = wp_insert_post( $my_post );
                //Insert feature image
                insert_feature_images($image_url,$post_id);
                
                
              }
               

                 //echo "The post with id ".$post_id." has been posted." ;
  }



  function insert_feature_images($image_url,$post_id){
                  $image_url_new = parse_url($image_url, PHP_URL_SCHEME)."://";
                  $image_url_new .= parse_url($image_url, PHP_URL_HOST);
                  $image_url_new .= parse_url($image_url, PHP_URL_PATH);
                  $image_url_new = str_replace('%', '', $image_url_new);
                  //$image_url_new = substr($image_url_new, 0, strpos($image_url_new, '?'));
                  

                  $upload_dir = wp_upload_dir();
                  $image_data = file_get_contents($image_url_new);
                  $filename = basename($image_url_new);
                  

                  $valid_image_types = array('gif', 'jpeg', 'png','jpg');
                  $wp_filetype = wp_check_filetype($filename, null );
                  if (in_array($wp_filetype["ext"], $valid_image_types)) {  

                    if(wp_mkdir_p($upload_dir['path']))
                      $file = $upload_dir['path'] . '/' . $filename;
                    else
                      $file = $upload_dir['basedir'] . '/' . $filename;
                    file_put_contents($file, $image_data);

                      $attachment = array(
                      'post_mime_type' => $wp_filetype['type'],
                      'post_title' => sanitize_file_name($filename),
                      'post_content' => '',
                      'post_status' => 'inherit'
                      );
                      $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
                       require_once(ABSPATH . 'wp-admin/includes/image.php');
                       $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                      wp_update_attachment_metadata( $attach_id, $attach_data );

                      set_post_thumbnail( $post_id, $attach_id );

                }

                 
                  







                      
                  
                   
                  
                  
  }









  
  
  



      
