<?php

class Ct
{	
	public static function main ()
	{
		View::add ('text', 'hello world!');
		
		View::display ('helloworld');
	}
	
	public static function notFound ()
	{
		View::add ('section', 'notfound');
		
		header("HTTP/1.0 404 Not Found");
		
		View::display ('notfound');
	}
}
