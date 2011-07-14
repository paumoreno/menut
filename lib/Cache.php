<?php

class Cache
{   
    public static function get ($k)
    {
        if (!file_exists('../cache/'.md5($k)))
            return null;
        $obj = unserialize(file_get_contents('../cache/'.md5($k)));
        if ($obj->expires < time())
        {
            @unlink('../cache/'.md5($k));
            return null;
        }
        
        return $obj->contents;
    }
    
    public static function save ($k, $v, $seconds = 21600)
    {
        $obj = new stdClass();
        $obj->expires = time() + $seconds;
        $obj->contents = $v;
        
        file_put_contents ('../cache/'.md5($k), serialize($obj));
    }
    
    public static function delete ($k)
    {
        @unlink('../cache/'.md5($k));
    }
}
