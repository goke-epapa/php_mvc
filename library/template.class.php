<?php
/**
 * Created by PhpStorm.
 * User: Obasa
 * Date: 6/2/14
 * Time: 11:33 AM
 */

class Template {
    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($controller, $action){
        $this->_controller = $controller;
        $this->_action = $action;
    }

    /** Set Variables */
    function set($name, $value){
        $this->variables[$name] = $value;
    }

    /** Display Template */
    function render(){
        extract($this->variables);
        include(PARENT_DIR . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
    }
} 