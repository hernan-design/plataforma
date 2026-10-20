<?php

namespace App\Helpers;

use Illuminate\Support\HtmlString;

class HtmlHelper
{
    public static function style($url, $attributes = [], $secure = null)
    {
        $attrString = self::attributes($attributes);
        return new HtmlString('<link media="all" type="text/css" rel="stylesheet" href="'.asset($url, $secure).'"'.$attrString.'>');
    }

    public static function script($url, $attributes = [], $secure = null)
    {
        $attrString = self::attributes($attributes);
        return new HtmlString('<script src="'.asset($url, $secure).'"'.$attrString.'></script>');
    }

    public static function image($url, $alt = null, $attributes = [], $secure = null)
    {
        $attributes['alt'] = $alt;
        return new HtmlString('<img src="'.asset($url, $secure).'"'.self::attributes($attributes).'>');
    }

    public static function link($url, $title = null, $attributes = [], $secure = null)
    {
        $url = url($url, [], $secure);
        return new HtmlString('<a href="'.$url.'"'.self::attributes($attributes).'>'.($title ?: $url).'</a>');
    }

    protected static function attributes($attributes)
    {
        if (empty($attributes)) return '';
        $html = [];
        foreach ($attributes as $key => $value) {
            if (is_numeric($key)) $key = $value;
            if (!is_null($value)) $html[] = $key.'="'.e($value).'"';
        }
        return count($html) > 0 ? ' '.implode(' ', $html) : '';
    }
}
