<?php

    function env(string $var){

        $root = $_SERVER["DOCUMENT_ROOT"];
        $content = file_get_contents("$root/fs_sander/api/.env.local");
        
        $content = implode("", explode("\r", $content));
        
        $content = explode("$var=", $content)[1];

        $value = explode("\n", $content)[0];
        return $value;
        
        
        
    }