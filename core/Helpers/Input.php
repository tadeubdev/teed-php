<?php

class Input
{
    public static $data = [];

    public static function configureInputData()
    {
        self::$data = array_merge( self::$data, $_GET, $_POST );
    }

    public static function __callStatic($meth, $args)
    {
        $str = isset($args[0])? $args[0]: null;
        $IsNull = isset( $args[1] )? $args[ 1 ]: null;

        switch ($meth) {
            case 'all':
                return self::$data;
            break;
            #
            case 'has':
                if (!isset( $args[1] )) {
                    $args[1] = null;
                }

                if (!isset( $args[2] )) {
                    $args[2] = null;
                }
                return isset(self::$data[$str]) && !is_null(self::$data[$str])? $args[1]: $args[2];
            break;
            #
            case 'set':
                return self::$data[ $str ] = !isset(self::$data[$str]) || is_null(self::$data[$str])? $args[1]: $IsNull;
            break;
            #
            case 'get':
                return isset(self::$data[$str]) && !is_null(self::$data[$str])? self::$data[$str]: $IsNull;
            break;
        }
    }
}
