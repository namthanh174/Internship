<?php

require(plugin_dir_path(__FILE__) . 'libs/Aws/aws-autoloader.php');

use Aws\S3\S3Client;
use Aws\Credentials\CredentialsInterface;
use Aws\S3\Exception\S3Exception;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

//		use Aws\Common\Enum\Region;
//		use Aws\Common\Aws;
//		use Aws\S3\Enum\CannedAcl;
//		use Aws\S3\Exception\S3Exception;
//		use Guzzle\Http\EntityBody;
//
//
////get the $s3 object
//$config = array(
//	'credentials' => array(
//	'key' => 'AKIAJ53K3XBUJTZANQ3Q',
//    'secret' => '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'
//	),
//    'region' => 'us-west-2',
//	'version' => 'latest',
//	'scheme'  => 'http'
//);
//$s3 = S3Client::factory($config);
//
//
//try {
//    $bucketname = 'thanh.vo';            //my bucket name on s3
//    $filename = 'image.gif';                //my image on my server
//    $path = 'D:/XAMPP/htdocs/scrap/img/';        //the path where the image is located
//    $fullfilename = $path.$filename;
//
//    //this successfully lists the contents of the bucket I am interested in
//    foreach ($s3->getIterator('ListBuckets') as $bucket) {
//        foreach ($s3->getIterator('ListObjects', array('Bucket' => $bucket['Name'])) as $object) {
//            if ( $bucket['Name'] == $bucketname ) {
//                echo $bucket['Name'] . '/' . $object['Key'] . PHP_EOL;
//            }
//        }
//    }
//
//    //HERE ME HERE, PLEASE!  this is the code that throws the exception
//    $s3->putObject(array(
//        'Bucket' => $bucketname,
//        'Key'    => $filename, 
//        'Body'   => EntityBody::factory(fopen($fullfilename, 'r')),
//        'ACL'    => CannedAcl::PUBLIC_READ_WRITE,
//        'ContentType' => 'image/gif'
//    ));
//
//
//} catch (S3Exception $e) {
//    echo $e;
//}
//$filename = basename($link);  

function upload_s3($urls) {



    //return $urls;

    $key = "AKIAJ53K3XBUJTZANQ3Q";
    $secret = "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";
    $credentials = new Aws\Credentials\Credentials($key, $secret);

    $s3 = new Aws\S3\S3Client([
        'version' => 'latest',
        'region' => 'us-west-2',
        'credentials' => $credentials,
        'http' => [
            'verify' => false
        ],
    ]);







//    $url = trim($url);
//    if ($url != "") {
//        $raw_url = str_replace('%', '', $url);
//    }
//    if (strpos($url, '?')) {
//        $raw_url = substr($url, 0, strpos($url, '?'));
//    }
//    $filename = basename($raw_url); 
//    $link = $url;
    //$links = ["https://tctechcrunch2011.files.wordpress.com/2016/08/suspcious-texts.jpg?w=1024&h=494","https://tctechcrunch2011.files.wordpress.com/2016/08/219233_ahmed_mansoor-1.jpg?w=738","https://tctechcrunch2011.files.wordpress.com/2016/08/access.png?w=320&h=357"];



    $urls = array_filter($urls);
    //return $urls;
    $s3_url = array();
     

    foreach($urls as $url){
        $url = trim($url);
        
        if ($url != "") {
            $raw_url = str_replace('%', '', $url);
        }
        if (strpos($url, '?')) {
            $raw_url = substr($url, 0, strpos($url, '?'));
        }
        $filename = basename($raw_url);
        $link = $url;
        

        //$uploader = new MultipartUploader($s3, ABSPATH.'wp-content/uploads/file.zip', [
        //    'bucket' => 'thanh.vo',
        //    'key'    => 'my-file.zip',
        //]);

        $uploader = new MultipartUploader($s3, $link, [
            'bucket' => 'thanh.vo',
            'key' => $filename,
            'ACL' => 'public-read'
        ]);
        try {
            $result = $uploader->upload();
            //echo "Upload complete: {$result['ObjectURL']}\n";
            $s3_url[] = $result['ObjectURL'];
        } catch (MultipartUploadException $e) {
            echo $e->getMessage() . "\n";
        }
    }
    return $s3_url;
}
