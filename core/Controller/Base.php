<?php

namespace Controller;

use \App;
use \Files;
use \Engine;
use \Traits\Functions;

trait Base
{

    use Functions;
    public static $file_name;

    public static function getBase()
    {

        if (!isset(self::$base)) {
            preg_match_all('/((?:^|[A-Z])[a-z]+)/', get_class(), $matches);
            $base = \String::toSlug( implode( '-', $matches[0] ) );
        } else {
            $base = self::$base;
        }

        return $base;
    }

    public static function getView($file_name = 'index')
    {
        $file_name = sprintf('%s/%s.php', self::getBase(), $file_name);
        self::$file_name = $file_name;
        return new self;
    }

    public static function with($meth, $args)
    {
        self::$data[ $meth ] = $args;
        return new self;
    }

    public static function getDefaultView($page, $lateral = null)
    {
        self::$data['menulateral'] = !$lateral? 'default': self::getBase();
        self::$data['page'] = $page;
        self::returnView("default/page.php");
    }

    public static function returnView()
    {
        self::$data['base'] = self::getBase();
        Engine::$data['variables'] = self::$data;

        $file_name = \Dir::getViews( self::$file_name );
        Engine::renderBody( $file_name );

        $template = \Dir::getTemplates('template.php');
        Engine::renderTemplate( $template );
    }
}
