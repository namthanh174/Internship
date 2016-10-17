<?php


 
// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
$license = $input['license'];
$secret_key = $input['secret_key'];
$domain = $input['domain'];






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

 
// if($table != 'escraper_license'){
// 	return false;
// }




 
// escape the columns and values from the input object
$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
$values = array_map(function ($value) use ($link) {
  if ($value===null) return null;
  return mysqli_real_escape_string($link,(string)$value);
},array_values($input));
 
// build the SET part of the SQL command
$set = '';
for ($i=0;$i<count($columns);$i++) {
  $set.=($i>0?',':'').'`'.$columns[$i].'`=';
  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
}
 


//  $sql = "select count('ID') from `$table`".($key?" WHERE license='$key'":''); 
//   $result = mysqli_query($link,$sql);
// echo $result;exit();

// create SQL based on HTTP method
// switch ($method) {
//   case 'GET':
  
//   	$sql = "select * from `$table`".($key?" WHERE license='$key'":''); 
  	
//   	break;

//     // $sql = "select * from `$table`".($key?" WHERE id=$key":''); break;
//   case 'PUT':
//   $sql = "update `$table` set $set where license='$key'"; break;
//     // $sql = "update `$table` set $set where id=$key"; break;
//   case 'POST':
//   $sql = "insert into `$table` set $set"; break;
//     // $sql = "insert into `$table` set $set"; break;
//   case 'DELETE':
//   $sql = "delete `$table` where license='$key'"; break;
//     // $sql = "delete `$table` where id=$key"; break;
// }
$sql = "select * from `$table`".($key?" WHERE license='$license'":''); 
 
// excecute SQL statement
$result = mysqli_query($link,$sql);


$obj = mysqli_fetch_object($result);

$demo =$obj->secret_key;
$key_encrypt = 'wmBFwCcj8sPweloqD993027uU95nC5wXX900HYeW4';
 $secret_key_descrypt = eScraper_decrypt($key_encrypt,$demo);
 $domain_encrypt = eScraper_encrypt($key_encrypt,$domain);

// $domain_decrypt = eScraper_decrypt($key_encrypt,$domain_encrypt);
// echo $domain_decrypt;exit();

// echo $secret_key_descrypt .'--------'.$secret_key;exit();
if($obj->domain == NULL){
  if($secret_key == $secret_key_descrypt){
    $sql = "update `$table` set domain ='$domain_encrypt' where license='$license'"; 
    $result = mysqli_query($link,$sql);  
    // echo $sql;exit();  
    echo 'true';
  }else{
    echo 'false';
  }
}else{
  if(check_license_pro($secret_key,$obj->secret_key,$domain,$obj->domain)){
    echo 'true';
  }else{
    echo 'false';
  }
  
}

  


 
// die if SQL statement failed
// if (!$result) {
//   http_response_code(404);
//   die(mysqli_error());
// }
 
// // print results, insert id or affected row count
// if ($method == 'GET') {

//   if (!$key) echo '[';
//   for ($i=0;$i<mysqli_num_rows($result);$i++) {
//     echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
//   }
//   if (!$key) echo ']';
// } elseif ($method == 'POST') {
//   echo mysqli_insert_id($link);
// } else {
//   echo mysqli_affected_rows($link);
// }
 
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



