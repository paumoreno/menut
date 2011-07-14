<?php

class DB
{
    private static $verbose = false;
    
    private static $instance = null;
    
    private $dblink;
    
    private static function get()
    {
        if (self::$instance == null)
            self::$instance = new DB();
 
        return self::$instance;
    }
    
    private function __construct()
    {
        $this->dblink = mysql_connect (Config::get('dbhost'), Config::get('dbuser'), Config::get('dbpass'));
        mysql_select_db (Config::get('dbname'));
	    mysql_query ("SET NAMES utf8");
    }
    
    public static function query ($sql)
    {
        if (self::$verbose) echo "$sql<br />";
        return mysql_query ($sql, self::get()->dblink);
    }
    
    public static function getLastInsertedId ()
    {
    	return mysql_insert_id();
    }
    
    public static function fetchRow ($result)
    {
        return mysql_fetch_array ($result, MYSQL_ASSOC);
    }
    
    public static function close()
    {
        if (self::$instance != null)
            mysql_close(self::$instance->dblink);
    }
}
