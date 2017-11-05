<?php
/**
 * Created by PhpStorm.
 * User: Yoga
 * Date: 05.11.2017
 * Time: 9:02
 */
//функция редиректа на необходимую страницу
function redirect($to){
    header("Location: {$to}");
    die;
}

//проверяет наличие ключа в POST
function requestPost($key, $default = null){
    return isset($_POST[$key]) ? $_POST[$key]:$default;
}

//проверяет наличие ключа в GET
function requestGet($key, $default = null){
    return isset($_GET[$key]) ? $_GET[$key]:$default;
}