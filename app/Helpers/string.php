<?php

use Illuminate\Support\HtmlString;
use League\CommonMark\GithubFlavoredMarkdownConverter;

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

if(!function_exists('markdown')) {
    function markdown($string, $options=[]): HtmlString
    {
        $options = array_merge($options, [
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
        ]);
        $converter = new GithubFlavoredMarkdownConverter($options);
        return new HtmlString($converter->convert($string ?? ''));
    }
}

if(!function_exists('remove_markdown')) {
    function remove_markdown($string): string
    {
        $patterns = [
            '/^#+([^#].*)?$/' => '$1',
            '/^=+\r\n/' => '',
            '/^\-+\r\n/' => '',
            '/>(.*)$/' => '$1',
            '/\[(.*)\]\(.*\)/' => '$1',
            '/\*(.*)\*/' => '$1',
            '/_(.*)_/' => '$1',
            '/\*\*(.*)\*\*/' => '$1',
            '/__(.*)__/' => '$1',

        ];
        foreach($patterns as $pattern => $replace){
            $string = preg_replace($pattern.'m', $replace, $string);
        }
        return $string; 
    }
}
