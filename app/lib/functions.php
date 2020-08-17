<?php
function getDomain(){
    return ( $_SERVER["HTTPS"] !== 'on' ) ? 'http://' . $_SERVER["SERVER_NAME"]  : 'https://' . $_SERVER["SERVER_NAME"];;
}

function pass_verify($pass, $hash){
    dd(hash_algos());
}