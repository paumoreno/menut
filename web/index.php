<?php

require_once ('../lib/Bootstrap.php');
Bootstrap::loadDir ('../ct');
Bootstrap::loadDir ('../lib');
Bootstrap::loadDir ('../model');


if (substr($_SERVER['HTTP_HOST'], 0, 3) == 'www')
	Response::rawRedirect301('http://'.substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI']);

Session::start();

Session::tryLogin();

//Cache::save('hola', 'provant cache', 20);
//Cache::delete('hola');
//echo Cache::get('hola');

if (Url::getController() == '')
    Ct::main();
else
	Ct::notFound();

DB::close();
