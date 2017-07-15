<?php

// >= php 5.3.0
spl_autoload_register(function($class) {
	if (!preg_match('/^Qcloud_cos/i', $class, $match)) return;
    $dir = dirname(__FILE__);
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    include($dir.DIRECTORY_SEPARATOR.$class); 
});