<?php

class Url
{
    private $controller = '';
    private $sections = array();
    private $params = array();
    
    private static $instance = null;
    
    private static function init()
    {
        if (self::$instance == null )
            self::$instance = new Url();
            
        return self::$instance;
    }
    
    private function __construct()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestUri = substr($requestUri,strlen(Config::get('basedir')));
        
        //echo Config::get('baseDir');
        //echo "request uri:$requestUri<br/>";
        
        $parts = array_values(array_filter(explode('?', $requestUri)));
        //print_r($parts);
        
        $sections = array_values(array_filter(explode('/', $parts[0])));
        //print_r($sections);

        foreach ($sections as $k=>$v)
        {
            if ($k == 0)
                $this->controller = addslashes(urldecode($v));
            else
                $this->sections[] = addslashes(urldecode($v));
        }
        
        $qs = array_filter(explode ('&', $parts[1]));
        
        foreach ($qs as $param)
        {
            $pieces = explode ('=', $param);
            $this->params[urldecode($pieces[0])] = addslashes(urldecode($pieces[1]));
        }
    }
    
    public static function getController ()
    {
        return self::init()->controller;
    }
    
    public static function getSections($n = null)
    {
        if (!is_null($n))
            return self::init()->sections[$n];
        else
            return self::init()->sections;
    }
    
    public static function getParams($k = null)
    {
        if (!is_null($k))
            return self::init()->params[$k];
        else
            return self::init()->params;
    }
    
    public static function get()
    {
        return 'http://'.$_SERVER['HTTP_HOST'].'/'.Config::get('basedir');
    }
}
