<?php

namespace App\Helpers;

use Illuminate\Support\HtmlString;

class FormHelper
{
    public static function open($options = [])
    {
        $method = strtoupper($options['method'] ?? 'POST');
        $append = '';
        if ($method !== 'GET' && $method !== 'POST') {
            $append = '<input type="hidden" name="_method" value="'.$method.'">';
            $method = 'POST';
        }
        if ($method !== 'GET') {
            $append .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
        }
        
        $action = '';
        if (isset($options['url'])) {
            $action = url($options['url']);
        } elseif (isset($options['route'])) {
            $action = route($options['route']);
        } elseif (isset($options['action'])) {
            $action = action($options['action']);
        }

        $options['method'] = $method;
        if ($action) $options['action'] = $action;
        
        unset($options['url'], $options['route']);
        if (isset($options['files']) && $options['files']) {
            $options['enctype'] = 'multipart/form-data';
            unset($options['files']);
        }

        return new HtmlString('<form'.self::attributes($options).'>'.$append);
    }

    public static function close()
    {
        return new HtmlString('</form>');
    }

    public static function text($name, $value = null, $options = [])
    {
        return self::input('text', $name, $value, $options);
    }

    public static function email($name, $value = null, $options = [])
    {
        return self::input('email', $name, $value, $options);
    }

    public static function hidden($name, $value = null, $options = [])
    {
        return self::input('hidden', $name, $value, $options);
    }

    public static function password($name, $options = [])
    {
        return self::input('password', $name, '', $options);
    }

    public static function submit($value = null, $options = [])
    {
        $options['type'] = 'submit';
        return new HtmlString('<button'.self::attributes($options).'>'.e($value).'</button>');
    }

    public static function textarea($name, $value = null, $options = [])
    {
        $options['name'] = $name;
        return new HtmlString('<textarea'.self::attributes($options).'>'.e($value).'</textarea>');
    }

    public static function checkbox($name, $value = 1, $checked = null, $options = [])
    {
        if ($checked) $options['checked'] = 'checked';
        return self::input('checkbox', $name, $value, $options);
    }

    public static function radio($name, $value = null, $checked = null, $options = [])
    {
        if ($checked) $options['checked'] = 'checked';
        return self::input('radio', $name, $value, $options);
    }

    public static function select($name, $list = [], $selected = null, $options = [])
    {
        $options['name'] = $name;
        $html = [];
        foreach ($list as $value => $display) {
            $sel = ($selected == $value) ? ' selected="selected"' : '';
            $html[] = '<option value="'.e($value).'"'.$sel.'>'.e($display).'</option>';
        }
        return new HtmlString('<select'.self::attributes($options).'>'.implode('', $html).'</select>');
    }

    protected static function input($type, $name, $value, $options)
    {
        $options['type'] = $type;
        $options['name'] = $name;
        if (!is_null($value)) $options['value'] = $value;
        return new HtmlString('<input'.self::attributes($options).'>');
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
