<?php

$envs = array
(
    'local' => '^(localhost|menut-local\.com)$',
    'prod' => '^(www\.)?example\.(com|net)$',
);

$config = array
(
    
    'dbserver' => array
    (
        'local' => 'localhost',
        'prod' => 'localhost',
    ),
    
    'dbuser' => array
    (
        'local' => 'root',
        'prod' => '',
    ),
    
    'dbpass' => array
    (
        'local' => '',
        'prod' => '',
    ),
    
    'dbname' => array
    (
        'local' => 'testdb',
        'prod' => '',
    ),
    
    'basedir' => array
    (
        'local' => '',
        'prod' => '',
    ),
    
    'root' => dirname(dirname(__FILE__)),
);
