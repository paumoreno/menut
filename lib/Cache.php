<?php

class Cache
{
    const WEEK = 604800;
	const DAY = 86400;
	const HOUR = 3600;
	
    public static function getFolder () {
		return  dirname(dirname(__FILE__))."/cache/";
	}
	
    public static function get ($k)
    {
        if (!file_exists(self::getFolder().md5($k)))
            return null;
        $obj = unserialize(file_get_contents(self::getFolder().md5($k)));
        if ($obj->expires < time())
        {
            @unlink(self::getFolder().md5($k));
            return null;
        }
        
        return $obj->contents;
    }
    
    public static function save ($k, $v, $seconds = 21600)
    {
        $obj = new stdClass();
        $obj->expires = time() + $seconds;
        $obj->contents = $v;
        
        file_put_contents (self::getFolder().md5($k), serialize($obj));
    }
    
    public static function delete ($k)
    {
        @unlink(self::getFolder().md5($k));
    }
    
    /**
	* Cleans expired cache files
	* 
	* @return void
	*/
    public static function deleteGarbage () {
		$files = array_slice(scandir(self::getFolder()), 2); // skip ./.. folders
		
		foreach ($files as $file) {
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			
			// delete only cache files
			if ($ext != '') {
				continue;
			}
			
			$obj = unserialize(file_get_contents($file));
        
			if ($obj->expires < time()) {
	            @unlink(self::getFolder().$file);
	        }
		}
	}
}
