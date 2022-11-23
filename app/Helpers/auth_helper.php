<?php 

function checkKey($key){
    $apiKey = getenv('API_KEY');

    if($key == $apiKey){
        return true;
    }
    else {
        return false;
    }
}