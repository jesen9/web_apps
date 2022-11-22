<?php

$data = json_decode(file_get_contents('php://input'), true);

if(isset(getallheaders()['X-Request-Verification'])){
    // GET URL
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
        $url = "https://";
    }
    else{
        $url = "http://";
    }
    $url.= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

// GET QUERY STRING / REQUEST BODY
    $post_body_request = $_SERVER['QUERY_STRING'];

// REMOVE QUERY STRING FROM URL
    $url = str_replace($post_body_request, "", $url);

// GET RAW CHECKSUM STRING
    $checksum = $url.'|'.$post_body_request;

// HASH CHECKSUM
    $hashed_checksum = hash("sha256", $checksum);

    if(getallheaders()['X-Request-Verification'] === $hashed_checksum){
        echo "Verification OK";
    }
    else {
        echo "Request Verification Failed";
    }
}
else {
    echo "Request Verification Failed";
}

