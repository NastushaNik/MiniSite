<?php
/**
 * Created by PhpStorm.
 * User: Yoga
 * Date: 30.10.2017
 * Time: 7:28
 */

require 'functions.php';

//$controller = $_GET['controller'];
//аналогия со строкой выше, но уже с проверкой на наличии ключа
// в файле function.php, если ключа нет, открываем страницу
// по умолчанию books.php
$controller = requestGet('controller', 'books');

$controllerFile = "{$controller}.php";

// в файле function.php, если ключа нет
if (!file_exists($controllerFile)){
    // по умолчанию books.php
    $controllerFile = 'books.php';
}

require $controllerFile;

require 'layout.phtml';
