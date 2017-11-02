<?php
/**
 * Created by PhpStorm.
 * User: Yoga
 * Date: 30.10.2017
 * Time: 7:28
 */

$controller = $_GET['controller'];

require '{$controller}.php';

require 'layout.phtml';
