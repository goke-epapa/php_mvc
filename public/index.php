<?php
/**
 * Created by PhpStorm.
 * User: Obasa
 * Date: 6/2/14
 * Time: 10:55 AM
 */

// Constants
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('PARENT_DIR', dirname(dirname(__FILE__)));

$url = 'site/index';
if(isset($_GET['url'])){
    $url = $_GET['url'];
}

$config = parse_ini_file(PARENT_DIR . DS . 'config/config.ini');
require_once(PARENT_DIR . DS . 'library' . DS . 'bootstrap.php');