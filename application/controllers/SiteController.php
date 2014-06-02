<?php
/**
 * Created by PhpStorm.
 * User: Obasa
 * Date: 6/2/14
 * Time: 11:53 AM
 */

class SiteController extends Controller{
    function index(){
        $this->setTemplate('all');
        $this->set('value', 'Hello World');
        $this->render();
    }
} 