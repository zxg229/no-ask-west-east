<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2016/6/11
 * Time: 11:54
 */

function htmlentities_custom($str){
    return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

function getCompleteAddress($sourcePath){
    $httphost = $_SERVER ['HTTP_HOST'];
    return 'http://'.$httphost.'/'.$sourcePath;
}