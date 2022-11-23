<?php 

function urlToArrayReverse(){
    return array_reverse(explode('/' , $_SERVER['PHP_SELF']));

}