<?php
namespace Blog;

/**
 * Description of Module
 *
 * @author emi
 */
class Module {
   
    function getConfig(){
        return require_once __DIR__.'/../config/module.config.php';
    }
}
