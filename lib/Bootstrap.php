<?php

class Bootstrap
{
    public static function loadDir ($path)
    {
        $dh = @opendir ($path);
        
        while (false !== ($file = readdir($dh)))
            if (preg_match ('/\.(php|inc)$/', $file))
                require_once ("$path/$file");
        
        closedir ($dh);
    }
}
