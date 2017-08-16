<?php

class Teed
{

    public static function setContent($content, $str)
    {
        return Engine::$data['content'][$content] = $str;
    }

    public static function getContent($content)
    {
        if (!isset( Engine::$data['content'][$content] )) {
            Engine::$data['content'][$content] = "";
        }

        return Engine::$data['content'][$content];
    }

    public static function setVariable($name, $str)
    {
        Engine::$data['variables'][$name] = $str;
    }

    public static function getVariable($name, $nullValue = null)
    {
        if (!isset( Engine::$data['variables'][$name] )) {
            echo $nullValue;
        } else {
            $data = Engine::$data['variables'][$name];

            if (is_array($data) || is_object($data)) {
                return $data;
            }

            echo $data;
        }
    }

    public static function getVariables()
    {
        return Engine::$data['variables'];
    }

    public static function includeFile($file)
    {
        $file = preg_replace('/(\.)/', '/', $file);
        $file = Dir::getSrc("{$file}.php");
        return Engine::cacheFile($file);
    }

    public static function includePartial($file)
    {
        $file = preg_replace('/(\.)/', '/', $file);
        $file = Dir::getSrc("templates/{$file}.php");

        if (!isset(Engine::$data['partials'])) {
            Engine::$data['partials'] = [];
        }

        Engine::$data['partials'][ $file ] = true;
        return Engine::cacheFile($file);
    }
}
