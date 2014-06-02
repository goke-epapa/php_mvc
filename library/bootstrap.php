<?php
/**
 * User: Adegoke Obasa
 * Date: 6/2/14
 * Time: 10:59 AM
 */

/**
 * Check if environment is developement and display errors
 */
function setReporting()
{
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT . DS . 'tmp' . DS . 'error.log');
    }
}

/** Check for Magic quotes and remove them */
function stripSlashesDeep($value)
{
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);

    return $value;
}

function removeMagicQuotes()
{
    if (get_magic_quotes_gpc()) {
        $_GET = stripSlashesDeep($_GET);
        $_POST = stripSlashesDeep($_POST);
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

/** Check register globals and remove them */
function unregisterGlobals()
{
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** Main Call Function */
function callHook()
{
    try {
        global $url;

        $urlArray = array();
        $urlArray = explode('/', $url);

        $queryArray = explode('?', $_SERVER['REQUEST_URI']);
        if(count($queryArray) >= 2){
            parse_str($queryArray[1], $queryArray);
            $_GET = $queryArray;
        }

        $controller = $urlArray[0];
        array_shift($urlArray);
        $action = 'index';
        if(isset($urlArray[0]))
            $action = $urlArray[0];

        $controllerName = $controller;
        $controller = ucwords($controller);
        $model = rtrim($controller, 's');
        $controller .= 'Controller';

        if(class_exists($controller, true)){
            $dispatch = new $controller($model, $controllerName, $action);

            if ((int)method_exists($controller, $action)) {
                call_user_func_array(array($dispatch, $action), array());
            } else {
                /**
                 * Error Generation Code Here
                 */
                echo "Not Found";
            }
        }else{
            echo "Not Found";
        }
    } catch (ErrorException $e) {
        echo "Application error:" . $e->getMessage();
    }

}

/**
 * Autoload any classes that are required
 */
function myautoloader($className)
{
    if (file_exists(PARENT_DIR . DS . 'library' . DS . strtolower($className) . '.class.php')) {
        require_once(PARENT_DIR . DS . 'library' . DS . strtolower($className) . '.class.php');
    } else if (file_exists(PARENT_DIR . DS . 'application' . DS . 'controllers' . DS . $className . '.php')) {
        require_once(PARENT_DIR . DS . 'application' . DS . 'controllers' . DS . $className . '.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php')) {
        require_once(PARENT_DIR . DS . 'application' . DS . 'models' . DS . $className . '.php');
    } else {
        /* Error Generation Code Here */
        echo("Unable to load file for class " . $className);
    }
}

function setConfig($config){
    foreach($config as $key => $value){
        define($key, $value);
    }
}
spl_autoload_register('myautoloader');
setConfig($config);
setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();
