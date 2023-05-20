<?php

use App\Models\Option;

if(!function_exists('option')) {
    function option($value)
    {
        if(is_array($value)){
            foreach($value as $k => $v){
                return Option::put($k, $v);
            }
        } else {
            return Option::get($value);
        }
    }
}
