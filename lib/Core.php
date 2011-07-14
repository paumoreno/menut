<?php

class Core
{
    public static function objExtract ($arr, $v, $k = null)
    {
        if (!is_array($arr)) $arr = array ($arr);
        
        $result = array ();
        foreach ($arr as $obj)
        {
            if (is_null($k))
                $result[] = $obj->$v;
            else
                $result[$obj->$k] = $obj->$v;
        }
        return $result;
    }
    
    public static function getWeekday ($tstamp)
    {
    	$day = date('N', $tstamp);
    	
    	switch ($day)
    	{
    		case '1': return 'Lunes';
    		case '2': return 'Martes';
    		case '3': return 'Miércoles';
    		case '4': return 'Jueves';
    		case '5': return 'Viernes';
    		case '6': return 'Sábado';
    		case '7': return 'Domingo';
    	}
    }
    
    public static function getMonth ($tstamp)
    {
    	$month = date('n', $tstamp);
    	
    	switch ($month)
    	{
    		case '1': return 'enero';
    		case '2': return 'febrero';
    		case '3': return 'marzo';
    		case '4': return 'abril';
    		case '5': return 'mayo';
    		case '6': return 'junio';
    		case '7': return 'julio';
    		case '8': return 'agosto';
    		case '9': return 'septiembre';
    		case '10': return 'octubre';
    		case '11': return 'noviembre';
    		case '12': return 'diciembre';
    	}
    }
    
    public static function getShortMonth ($tstamp)
    {
    	$month = date('n', $tstamp);
    	
    	switch ($month)
    	{
    		case '1': return 'ene';
    		case '2': return 'feb';
    		case '3': return 'mar';
    		case '4': return 'abr';
    		case '5': return 'may';
    		case '6': return 'jun';
    		case '7': return 'jul';
    		case '8': return 'ago';
    		case '9': return 'sep';
    		case '10': return 'oct';
    		case '11': return 'nov';
    		case '12': return 'dic';
    	}
    }
    
    public static function urlFriendly ($str)
    {
		$str = mb_strtolower($str, "UTF-8");
		$unsafe = array ("à", "á", "ä", "è", "é", "ë", "ì", "í", "ï", "ò", "ó", "ö", "ù", "ú", "ü", "ç", "ñ", " ");
		$safe   = array ("a", "a", "a", "e", "e", "e", "i", "i", "i", "o", "o", "o", "u", "u", "u", "c", "n", "-");
		$str = str_replace ($unsafe, $safe, $str);
		return preg_replace ("/[^a-z0-9\-]/", "", $str);
    }
    
    public static function getRemainingTime ($then)
    {
    	$now = time ();
    	$diff = $then - $now;
    	
    	if ($diff > 60 * 60 * 48)
    	{
    		$days = floor($diff / (60 * 60 * 24));
    		$str = "Faltan $days días";
    	}
    	elseif ($diff > 60 * 60 * 24)
    	{
    		$str = "Falta un día";
    	}
    	elseif ($diff > 60 * 60 * 2)
    	{
    		$hours = floor($diff / (60 * 60));
    		$str = "Faltan $hours horas";
    	}
    	elseif ($diff > 60 * 60)
    	{
    		$str = "Falta 1 hora";
    	}
		elseif ($diff > 60 * 5)
    	{
    		$minutes = floor($diff / (60));
    		$str = "Faltan $minutes minutos";
    	}
    	else
    	{
    		$str = "¡A punto de empezar!";
    	}
    	
    	return $str;
    }
    
    public static function getCssDeclarations ($files)
    {
    	$files = explode ('|', $files);
    	
    	$decls = '';
    	foreach ($files as $file)
    	{
    		if (file_exists (Config::get('root').'/web/css/'.$file.'.css'))
    			$appendix = '?v='.filectime(Config::get('root').'/web/css/'.$file.'.css');
    		else
    			$appendix = '';
    		
    		$decls .= '<link type="text/css" href="'.Url::get().'css/'.$file.'.css'.$appendix.'" rel="stylesheet" />'."\n";
    	}
    	
    	return $decls;
    }
    
    public static function getJsDeclarations ($files)
    {
    	$files = explode ('|', $files);
    	
    	$decls = '';
    	foreach ($files as $file)
    	{
    		if (file_exists (Config::get('root').'/web/js/'.$file.'.js'))
    			$appendix = '?v='.filectime(Config::get('root').'/web/js/'.$file.'.js');
    		else
    			$appendix = '';
    		
    		$decls .= '<script type="text/javascript" src="'.Url::get().'js/'.$file.'.js'.$appendix.'"></script>'."\n";
    	}
    	
    	return $decls;
    }
}

function getParam ($k)
{
	if (isset ($_POST[$k])) {
		return trim(addslashes(strip_tags($_POST[$k])));
	} else {
		return trim(addslashes(strip_tags($_GET[$k])));
	}
}

function dprint ($var)
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}
