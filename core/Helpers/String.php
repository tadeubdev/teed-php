<?php

class String
{

    public static function toSlug($str, $replace = [], $delimiter = '-')
    {
        if (!empty($replace)) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    public static function toText($str)
    {
        return ucwords( str_replace( '-', ' ', $str ) );
    }

    public static function emptyOrNull($str, $isNull = null)
    {
        return isset( $str ) && !is_null( $str )? $str: $isNull;
    }

    public static function getFirstExplodeString($delm, $string)
    {
        return explode( $delm, $string )[0];
    }

    public static function getEndExplodeString($delm, $array)
    {
        $array = explode( $delm, $array );
        return end( $array );
    }

    public static function getData($array)
    {
        $joins = func_get_args();
        array_shift( $joins );

        if (!count($array)) {
            return [];
        }

        if (!is_array($array)) {
            $uniq = true;
            $array = [$array];
        }

        foreach ($array as &$row) {
            $attributes = (object) $row->attributes();

            if (count($joins)) {
                foreach ($joins as $key) {
                    $attributes->$key = $row->$key->attributes();
                }
            }

            foreach ($attributes as $key => &$value) {
                if (is_object($value) && get_class($value)) {
                    $newValue = [];

                    foreach ($value as $int => $item) {
                        $newValue[$int] = $item;
                    }

                    $value = isset($newValue['date'])? $newValue['date']: $newValue;
                }
            }

            foreach ($attributes as $key => &$value) {
                if (is_array($value)) {
                    foreach ($value as $collum => &$item) {
                        if (!isset($attributes->$collum)) {
                            $attributes->$collum = utf8_encode( $item );
                        }

                        $item = utf8_encode( $item );
                    }

                    $value = (object) $value;

                    if (isset($value->name)) {
                        $value->slug = "{$value->id}-" . self::toSlug( $value->name );
                    }
                } else {
                    $value = utf8_encode( $value );
                }
            }

            $row = (object) $attributes;

            if (isset($row->name)) {
                $row->slug = "{$row->id}-" . self::toSlug( $row->name );
            }
        }

        if (isset($uniq)) {
            $array = $array[0];
        }

        return $array;
    }

    public static function php($fn)
    {
        return "<?php $fn ?>";
    }

    public static function toObject($array)
    {

        if (is_string($array) || is_object($array)) {
            return utf8_encode( $array );
        } elseif (is_array($array)) {
            foreach ($array as &$value) {
                if (!is_scalar($value)) {
                    $value = (object) $value;
                }
            }

            return $array;
        }
    }

    public static function toArray($array)
    {
        if (is_string($array) || is_array($array)) {
            return utf8_encode( $array );
        } elseif (is_object($array)) {
            foreach ($array as &$value) {
                if (!is_scalar($value)) {
                    $value = (object) $value;
                }
            }

            return $array;
        }
    }

    public static function removeItemOfArray($index, $array)
    {
        $response = [];

        foreach ($array as $key => $value) {
            if ($key !== $index) {
                if (is_numeric( $index )) {
                    $response[] = $value;
                } else {
                    $response[ $key ] = $value;
                }
            }
        }

        return $response;
    }

    public static function countExplode($delm, $array)
    {
        $array = explode( $delm, $array );
        return count( $array );
    }
}
