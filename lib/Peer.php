<?php

class Peer
{
    private static $instances = array ();
    
    private static function get ($type)
    {
        if (!isset ($instances[$type]))
        {
            $instances[$type] = new Peer ($type);
        }
        
        return $instances[$type];
    }
    
    private function __construct ($type)
    {
        $this->type = $type;
        $this->pool = array ();
    }
    
    public static function getByCriteria ($type, $criteria = null)
    {
        if (is_null($criteria)) $criteria = new Criteria();
        
        $sql = "SELECT * FROM $type $criteria";
        $res = DB::query ($sql);
        
        $results = array ();
        while ($row = DB::fetchRow($res)) 
        {
            $obj = new $type();
            foreach ($row as $k=>$v)
                $obj->$k = $v;
            $results[] = $obj;
        }
        
        return $results;
    }
    
    public static function getById ($type, $id)
    {
        if (!is_numeric($id)) return null;
        
        $sql = "SELECT * FROM $type WHERE id = $id";
        $res = DB::query ($sql);
        
        if ($row = DB::fetchRow($res)) 
        {
            $obj = new $type();
            foreach ($row as $k=>$v)
                $obj->$k = $v;
            
            return $obj;
        }
        
        return null;
    }
    
    public static function countByCriteria ($type, $criteria = null)
    {
        if (is_null($criteria)) $criteria = new Criteria();
        
        $sql = "SELECT count(*) AS num FROM $type $criteria";
        $res = DB::query ($sql);
        
        if ($row = DB::fetchRow($res)) 
            return $row['num'];
        
        return 0;
    }
    
    public static function deleteByCriteria ($type, $criteria = null)
    {
        if (is_null($criteria)) $criteria = new Criteria();
        
        $sql = "DELETE FROM $type $criteria";
        $res = DB::query ($sql);
        
        return $res;
    }
}
