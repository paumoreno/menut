<?php

class Criteria
{
    private $where;
    private $orderby;
    private $limit;
    
    public function __construct ($where = array (), $orderby = array (), $limit = array ())
    {
        $this->where = $where;
        $this->orderby = $orderby;
        $this->limit = $limit;
    }
    
    public function add ($cond, $value, $operator = '=')
    {
        $this->where[] = "$cond $operator '$value'";
    }
    
    public function addStatic ($cond)
    {
        $this->where[] = $cond;
    }
    
    public function in ($field, $values, $not = false)
    {
        $strval = implode ("','", $values);
        
        if (!$not)
            $this->where[] = "$field IN ('$strval')";
        else
            $this->where[] = "$field NOT IN ('$strval')";
    }
    
    public function addOrderby ($order)
    {
        $this->orderby[] = $order;
    }
    
    public function addLimit ($offset, $size = null)
    {
        if (is_null($size))
        {
            $this->limit[0] = 0;
            $this->limit[1] = $offset;
        }
        else
        {
            $this->limit[0] = $offset;
            $this->limit[1] = $size;
        }
    }
    
    public function __toString ()
    {
        $result = '';
        
        if (count($this->where))
            $result .= 'WHERE ' . implode (' AND ', $this->where);
        
        if (count($this->orderby))
            $result .= ' ORDER BY ' . implode (', ', $this->orderby);
        
        if (count($this->limit))
            $result .= ' LIMIT ' . implode (', ', $this->limit);
        
        return $result;
    }

}
