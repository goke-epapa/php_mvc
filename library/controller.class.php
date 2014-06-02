<?php
/**
 * Created by PhpStorm.
 * User: Obasa
 * Date: 6/2/14
 * Time: 11:24 AM
 */

class Controller
{
    protected $_controller;
    protected $_action;
    protected $_template;

    function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_controller = $action;
    }

    function setTemplate($view)
    {
        $this->_template = new Template($this->_controller, $view);
    }

    function set($name, $value)
    {
        $this->_template->set($name, $value);
    }

    function render()
    {
        $this->_template->render();
    }

}