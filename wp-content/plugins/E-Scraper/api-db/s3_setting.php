<?php 
require('jwt/jwt_helper.php');
require('aws_s3/Aws/aws-autoloader.php');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;



$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

$list_images = $input['list_images'];
$license = $input['license'];
$key_s3 = $input['key_s3'];    
$secret = $input['secret'];
$bucket_name = $input['bucket_name'];
$token = $input['token'];


if($token == ''){
  echo 'error';exit();
}

$token = JWT::decode($token, 'secret_server_key');
 if($token->id == 'ES'.$license){
     $aws_s3_list = upload_s3($list_images,$key_s3,$secret,$bucket_name);
    echo json_encode($aws_s3_list);    
  }else{
      echo "error";
  }




function upload_s3($urls,$key,$secret,$bucket_name){

    // $credentials = new Aws\Credentials\Credentials($key,$secret);

    $s3 = new S3Client([
        'region'   => 'us-west-2',
          'version'  => 'latest',
          'credentials' => [
            'key' => $key,
            'secret' => $secret,
          ],
          'http' => [
            'verify' => false
        ]
      ]);




    $links = array_filter($urls);

    $s3_url = array();


    foreach ($links as $url) {

        $url = trim($url);
        
        if ($url != "") {
            $raw_url = str_replace('%', '', $url);
        }
        if (strpos($url, '?')) {
            $raw_url = substr($url, 0, strpos($url, '?'));
        }
        
        $filename = basename($raw_url);
        
          
          
        $img_data = file_get_contents($url);

          try {
              // Upload data.
              $result = $s3->putObject([
                      'Bucket' => $bucket_name,
                      'Key' => 'image/'.$filename,
                      'Body'   => $img_data,
                      'ACL' => 'public-read'
                    ]);
              $s3_url[] = $result['ObjectURL'];
              
          } catch (S3Exception $e) {
             echo json_encode(array("data"=>$e->getMessage()));exit();
          }
        
       
    }
   
    return $s3_url;
}









// use Aws\S3\MultipartUploader;
// use Aws\Exception\MultipartUploadException;
// function upload_s3_1($urls,$key,$secret,$bucket_name) {
//     //return $urls;

//     // $key = trim(get_option('s3_key_id'));    
//     // $secret = trim(get_option('s3_secret_key'));
//     // $bucket_name = trim(get_option('s3_name'));
    
    
//     $credentials = new Aws\Credentials\Credentials($key,$secret);

//     $s3 = new Aws\S3\S3Client([
//         'version' => 'latest',
//         'region' => 'us-west-2',
//         'credentials' => $credentials,
//         'http' => [
//             'verify' => false
//         ]
//     ]);




//     $links = array_filter($urls);

//     $s3_url = array();


//     foreach ($links as $url) {
//         $url = trim($url);
        
//         if ($url != "") {
//             $raw_url = str_replace('%', '', $url);
//         }
//         if (strpos($url, '?')) {
//             $raw_url = substr($url, 0, strpos($url, '?'));
//         }
        
//         $filename = basename($raw_url);
//         $link = $url;


        


//         $uploader = new MultipartUploader($s3, $link, [
//             'bucket' => $bucket_name,
//             'key' => $filename,
//             'ACL' => 'public-read'
//         ]);
        
//             try {
//             $result = $uploader->upload();
//             $s3_url[] = $result['ObjectURL'];
//             } catch (MultipartUploadException $e) {
               
//                 echo json_encode(array("data"=>$e->getMessage()));exit();
//             }
        
       
//     }
//     //echo json_encode(array("data"=>$s3_url));exit();
//     return $s3_url;
// }

