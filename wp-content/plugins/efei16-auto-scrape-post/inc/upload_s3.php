<?php

require(plugin_dir_path(__FILE__) . 'libs/Aws/aws-autoloader.php');

use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

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




    $urls = array_filter($urls);

    $s3_url = array();


    foreach ($urls as $url) {
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
            'bucket' => 'thanh.vo',
            'key' => $filename,
            'ACL' => 'public-read'
        ]);
        try {
            $result = $uploader->upload();
            $s3_url[] = $result['ObjectURL'];
        } catch (MultipartUploadException $e) {
            echo $e->getMessage() . "\n";
        }
    }
    return $s3_url;
}
