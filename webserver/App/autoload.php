<?php

spl_autoload_register(function($className) {
    $className = str_replace('\\', '/', $className);

    $file = "../App/$className.php";

    if(file_exists($file))
    {
        require_once("../App/$className.php");
    }
    
});