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
                          "order"     => "ASC" );
                  $post_categories = get_categories($args);
                                                  
                  ?>
                  <h2><?php _e('Auto Scrape And Post','scrape'); ?></h2>

                  <div class="container">
                        <form action='' method='POST' id='scrape-form'>
                                  
                                  <div><span>URL :</span> </div>
                                  <input type="text" id="url" style="width:100%">

                                  <div><span>Categories :</span></div>
                                  <select id='type' name='type' style="width:100%">
                                                <?php
                                                 foreach ( $post_categories  as $category ) { ?>
                                                <option value="<?php echo $category->cat_ID; ?>">
                                                  <?php echo $category->cat_name; ?>                                                  
                                                </option>
                                                <?php }?>
                                              </select>
                                  
                                  
                                  <div><input type="submit" value="<?php _e('Submit','scrape'); ?>" id="getresult"></div>
                            
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



              if(!filter_var($url, FILTER_VALIDATE_URL)) {
                json_encode(array('error'=>'invalid_url'));
                die();
              }
              else {
                // $url = parse_url($url, PHP_URL_HOST);
                // echo $url;exit();

                $raw_url = parse_url($url, PHP_URL_HOST);
                $page = scrape($url);                
                $title = fetchdata($page,"<title>", "</title>");


                //Test
                // $data = $page;
                // $start ="itemprop='description articleBody'>";
                // $end = "<center>";
                // $data = stristr($data, $start); // Stripping all data from before $start
                // //echo $data;exit();
                // $data = substr($data, strlen($start));  // Stripping $start
                // //echo $data;exit();
                // $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
                // //echo $stop;exit();
                // $data = substr($data, 0, $stop);    // Stripping 
                // echo $data;exit();
                //End Test
                 


                $content = filter_content($page,$raw_url);
               //echo $content;exit();
                
                //Get image url
                //$image_url = fetchdata($content, "src=\"", "?w=");
                $image_url = fetchdata($content, "src=\"", "\"");
                //echo $image_url;exit();

               // Create post object
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
                  $image_url_new = parse_url($image_url, PHP_URL_SCHEME)."://";
                  $image_url_new .= parse_url($image_url, PHP_URL_HOST);
                  $image_url_new .= parse_url($image_url, PHP_URL_PATH);
                  $image_url_new = str_replace('%', '', $image_url_new);
                  //echo $image_url_new;exit();


                  $upload_dir = wp_upload_dir();
                  $image_data = file_get_contents($image_url_new);
                  $filename = basename($image_url_new);
                  if(wp_mkdir_p($upload_dir['path']))
                      $file = $upload_dir['path'] . '/' . $filename;
                  else
                      $file = $upload_dir['basedir'] . '/' . $filename;
                  file_put_contents($file, $image_data);

                  $wp_filetype = wp_check_filetype($filename, null );
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

                   //set_post_thumbnail( $post_id, $attach_id );
                    

                  echo $post_id ;
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


    function filter_content($page,$raw_url){

        if($raw_url == 'techcrunch.com')
        {
          $start = "<div class=\"article-entry text\">";
          $end = "<div id=\"social-after-wrapper\" class=\"cf social-share social-share-inline\">";  
        }
        else if($raw_url == 'www.marrybaby.vn')
        {
          

          $start = "<div class=\"article-details-content-details\">";
          $end = "<div class=\"article-footer-block item-clear-float\">";
        }
        else if($raw_url == 'www.tintucnongnghiep.com')
        {
          $start ="itemprop='description articleBody'>";
          $end = "<center>";
        }
        else
        {
          $start = "<div class=\"article-entry text\">";
          $end = "<div id=\"social-after-wrapper\" class=\"cf social-share social-share-inline\">";
        }
            
            
           $content = fetchdata($page,$start,$end);
           return $content;
    }



 










  
  
  



      
