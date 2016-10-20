<?php

require('jwt/jwt_helper.php');
$key_encrypt = 'wmBFwCcj8sPweloqD993027uU95nC5wXX900HYeW4';

 
// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
$license = $input['license'];
$secret_key = $input['secret_key'];
$domain = $input['domain'];
 

// $license = 'ES58049E787D74A';
// $secret_key = 'zS$b)ekMMx2@qnR&y#56W73TrpoWW+_p@ZlS9xfjcTB%l*qa*YIQH!k';
// $domain = 'localhost:8080';


// echo $license;
// echo $secret_key;
// echo $domain;exit();

// $test = $_REQUEST['test'];

// echo $license;exit();

// connect to the mysql database
$user = 'efe36702_dev';
$pass = 'melody123';
$dbname = 'efe36702_thanh_vo';
$link = mysqli_connect('localhost', $user, $pass, $dbname);
mysqli_set_charset($link,'utf8');



 
// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
 // $key = array_shift($request)+0;
 $key = array_shift($request);

 




 

 

$sql = "select * from `$table` WHERE license='$license'"; 
 
// excecute SQL statement
$result = mysqli_query($link,$sql);


$obj = mysqli_fetch_object($result);



 

 // echo $domain;exit();
if(check_license_pro($secret_key,$obj->secret_key,$domain,$obj->domain)){
  
  $token = array();
  $token['id'] = 'ES'.$obj->license;
  
  echo  JWT::encode($token, 'secret_server_key');
 
}

  



 
// close mysql connection
mysqli_close($link);










function eScraper_encrypt($key, $string)
{
  $iv = mcrypt_create_iv(
      mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
      MCRYPT_DEV_URANDOM
  );

  $encrypted = base64_encode(
      $iv .
      mcrypt_encrypt(
          MCRYPT_RIJNDAEL_128,
          hash('sha256', $key, true),
          $string,
          MCRYPT_MODE_CBC,
          $iv
      )
  );

  return $encrypted;
}

function eScraper_decrypt($key, $encrypted)
{
  $data = base64_decode($encrypted);
  $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

  $decrypted = rtrim(
      mcrypt_decrypt(
          MCRYPT_RIJNDAEL_128,
          hash('sha256', $key, true),
          substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
          MCRYPT_MODE_CBC,
          $iv
      ),
      "\0"
  );

  return $decrypted;
}
function eScraper_generate_secret_key () {
 
    $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789~!@#$%^&*()_+';
    $segment_chars = 56;
    // $num_segments = 4;
    $license_string = '';
 
    $segment = '';
 
    for ($j = 0; $j < $segment_chars; $j++) {
            $segment .= $tokens[rand(0, 75)];
    }

    $license_string .= $segment;

    return $license_string;
 
}






function check_license_pro($secret_key,$secret_key_db,$domain,$domain_db){
      $key = 'wmBFwCcj8sPweloqD993027uU95nC5wXX900HYeW4';
      $domain_decrypt = eScraper_decrypt($key,$domain_db);
      $secret_key_db_decrypt = eScraper_decrypt($key,$secret_key_db);

      if(($secret_key == $secret_key_db_decrypt) && ($domain == $domain_decrypt)){
        return true;
      }else{
        return false;
      }


}






 function generate_token_key($len = 16)
{
    $data = openssl_random_pseudo_bytes($len);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0010
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4));
}



