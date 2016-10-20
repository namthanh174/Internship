<?php 

require('jwt/jwt_helper.php');



$method = $_SERVER['REQUEST_METHOD'];
// $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
$license = $input['license'];
$token = $input['token'];
$define_url = $input['define_url'];
 

// connect to the mysql database
$user = 'efe36702_dev';
$pass = 'melody123';
$dbname = 'efe36702_thanh_vo';
$link = mysqli_connect('localhost', $user, $pass, $dbname);
mysqli_set_charset($link,'utf8');





if($token == ''){
  echo 'error';exit();
}


 $token = JWT::decode($token, 'secret_server_key');
 if($token->id == 'ES'.$license){

   $sql = "select * from `escraper_scrape_pattern` WHERE define_url='$define_url'"; 

    $result = mysqli_query($link,$sql);
    $obj = mysqli_fetch_object($result);
      
      if(($obj->define_category == NULL) || ($obj->define_category == '')){
        echo 'error';exit();
      }
      echo $obj->define_category; 
      
    

    
  }else{
      echo "error";
  }
    
 


// close mysql connection
 mysqli_close($link);









