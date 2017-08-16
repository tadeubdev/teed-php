<?php

class Response
{

    public static function json($array)
    {
        header('Content-type:text/json');
        echo json_encode( $array );
    }

    public static function utf8($input)
    {
        if (is_string($input)) {
            $input = utf8_encode($input);
        } elseif (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = self::utf8($value);
            }
            unset($value);
        } elseif (is_object($input)) {
            $vars = get_object_vars($input);
            foreach ($vars as $key => $var) {
                $input->$key = self::utf8($var);
            }
        }

        return $input;
    }
}
