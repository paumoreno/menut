<?php

class View
{
    private static $instance = null;
    
    private $type;
    
    private $vars; 
    
    private static function get()
    {
        if (self::$instance == null)
            self::$instance = new View();
 
        return self::$instance;
    }
    
    private function __construct()
    {
        $this->type = 'default';
        $this->vars = array();
    }
    
    public static function setType ($type)
    {
        self::get()->type = $type;
    }
    
    public static function add ($k, $v)
    {
        self::get()->vars[$k] = $v;
    }
    
    public static function display ($template)
    {
        extract (self::get()->vars);
        require ('../views/'.self::get()->type."/$template.php");
    }
}
