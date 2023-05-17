<?php

const BYTE_ARRAY = ['byte', 'KB', 'MB', 'GB', 'TB', 'PB'];

if(!function_exists('byte_to_unit')) {
    function byte_to_unit(int $bytes)
    {
        for($i = 0; 1024 < $bytes; $i++){
            $bytes /= 1024;
        }
        return round($bytes, 1).BYTE_ARRAY[$i];
    }
}
