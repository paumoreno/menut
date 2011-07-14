<?php

class DAO
{
    public function __construct ()
    {
    	$this->id = 0;
    }
    
    public function getSmart ($field, $fromtable = null)
    {
        if (isset($this->$field))
            return $this->$field;
        
        if (!is_null($fromtable))
            $object = $fromtable;
        else
            $object = $field;
        
        $fk = "fk_$field";
        
        if (isset($this->$fk))
            $this->$field = Peer::getById($object, $this->$fk);
        
        return $this->$field;
    }
    
    public function getMultiple ($object)
    {
        $name = $object.'s';
        
        if (isset($this->$name))
            return $this->$name;
        
        $intername = strtolower(get_class($this)).'_'.$object;
        
        $crit = new Criteria();
        $crit->add('fk_'.strtolower(get_class($this)), $this->id);
        
        $rels = Core::objExtract(Peer::getByCriteria ($intername, $crit), "fk_$object");
        
        $crit = new Criteria();
        $crit->in('id', $rels);
        $this->$name = Peer::getByCriteria ($object, $crit);
        
        
        return $this->$name;
    }
    
    public function save ()
    {
    	$table = strtolower(get_class($this));
    	
    	if ($this->id == 0)
    	{
    		$fields = array();
    		foreach ($this as $k=>$v)
    		{
    			$fields[] = $k;
    			
    			if ($k == 'id')
    				$values[] = 'null';
    			else
    				$values[] = "'".addslashes($v)."'";
    		}
    		
    		$fields = implode (',', $fields);
    		$values = implode (',', $values);
    		
    		$sql = "INSERT INTO $table ($fields) VALUES ($values)";
    		DB::query ($sql);
    		
    		$this->id = DB::getLastInsertedId();
    	}
    	else
    	{
    		$fields = array();
 			
 			$sets = array();   		
    		foreach ($this as $k=>$v)
    		{
    			if ($k != 'id')
    				$sets[] = ' '.$k." = '".addslashes($v)."'";
    		}
    			
    		$sets = implode (', ', $sets);
    		
    		$sql = "UPDATE $table SET $sets WHERE id = '{$this->id}'";
    		DB::query ($sql);
    	}
    }
    
    public function delete ()
    {
    	$table = strtolower(get_class($this));
    	
    	$sql = "DELETE FROM $table WHERE id = '{$this->id}'";
    	DB::query ($sql);
    }
}
