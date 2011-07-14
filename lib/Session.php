<?php

class Session
{
	public static function start ()
    {
        session_start();
    }
    
    public static function get ($k)
    {
    	return $_SESSION[$k];
    }
    
    public static function set ($k, $v)
    {
    	$_SESSION[$k] = $v;
    }
    
    public static function isLogged ()
    {
    	return self::get('logged');
    }
    
    public static function gateKeeper ()
    {
    	if (!self::isLogged())
    		Response::redirect ();
    }
    
    public static function logout ()
    {
    	self::set('logged', false);
    	self::set('user', null);
    	
    	Response::redirect ();
    }
    
	public static function tryLogin ()
	{
		if (strlen(getParam('usr')) && strlen(getParam('pwd')))
		{
			$crit = new Criteria ();
			$crit->add ('username', getParam('usr'));
			$crit->add ('password', md5(getParam('pwd')));
			
			$user = Peer::getByCriteria('user', $crit);
			if (count($user))
			{
				$user = $user[0];
				self::set ('logged', true);
				self::set ('user', $user);
				
				Response::redirect ('/backoffice/futurs');
			}
			else
			{
				sleep (5);
			}
		}
	}
}
