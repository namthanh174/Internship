<?php

require(plugin_dir_path(__FILE__) . 'libs/Aws/aws-autoloader.php');

use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

function upload_s3($urls) {
    //return $urls;

    $key = trim(get_option('s3_key_id'));    
    $secret = trim(get_option('s3_secret_key'));
    $bucket_name = trim(get_option('s3_name'));
    
  
    
    
    
    $credentials = new Aws\Credentials\Credentials($key,$secret);

    $s3 = new Aws\S3\S3Client([
        'version' => 'latest',
        'region' => 'us-west-2',
        'credentials' => $credentials,
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
        $link = $url;


        $uploader = new MultipartUploader($s3, $link, [
            'bucket' => $bucket_name,
            'key' => $filename,
            'ACL' => 'public-read'
        ]);
        
            try {
            $result = $uploader->upload();
            $s3_url[] = $result['ObjectURL'];
            } catch (MultipartUploadException $e) {
               
                echo json_encode(array("data"=>$e->getMessage()));exit();
            }
        
       
    }
    //echo json_encode(array("data"=>$s3_url));exit();
    return $s3_url;
}
