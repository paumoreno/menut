<?php

class Response
{
    public static function redirect ($url = '')
    {
        header ('Location: '.Config::getBaseUrl().$url);
        exit;
    }
    
    public static function rawRedirect301 ($url = '')
    {
        header ('Location: '.$url, TRUE, 301);
        exit;
    }
}
