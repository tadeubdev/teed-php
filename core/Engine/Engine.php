<?php

class Engine
{

    use \Traits\Functions;

    public static function verifyDifference($file, $cached)
    {
        if (!file_exists( $cached )) {
            return true;
        }

        $file = Carbon\Carbon::now()->timestamp(filemtime($file));
        $cached = Carbon\Carbon::now()->timestamp(filemtime($cached));

        return $cached < $file;
    }

    public static function cacheTemplate($file_name)
    {
        self::cacheFile( $file_name );
    }

    public static function cacheFile($file_name)
    {
        if (App::getEnv()->name == 'local') {
            $cached_file =  Dir::getCache( str_replace( [Dir::getSrc(),'/'], ['','-'], $file_name ) );
        } else {
            $cached_file =  Dir::getCache( sha1($file_name) );
        }

        $cached_file = preg_replace('/((?:(\.teed))?(\.php))/', '.cache-teed', $cached_file);

        if (self::verifyDifference( $file_name, $cached_file )) {
            $file = self::renderFile( $file_name );
            Files::putFile( $cached_file, $file, 'w+' );
            return $file;
        } else {
            return implode(' ', Files::getFile($cached_file));
        }
    }

    public static function renderFile($file)
    {
        $string = Files::getFile( $file );
        $variables = Files::getData( Dir::getCore('Engine/Variables.php'), true );

        foreach ($variables as $value) {
            $value = (array) $value;
            $value[0] = str_replace( ['(',')'], ['\(','\)'], $value[0] );
            $value[0] = str_replace( ['*'], ['(.*)'], $value[0] );
            $value[0] = "/({$value[0]})/" . (isset($value[2])? '': 'U');
            $string = preg_replace( $value[0], $value[1], $string );
        }

        return $string;
    }

    public static function renderVariables($file)
    {
        $response = [];

        if (preg_match_all("/(\{\-\- setContent\(('|\")(.*)('|\")\) \-\-\}(.*)\{\-\- endcontent \-\-\})/Us", $file, $types)>0) {
            foreach ($types[0] as $int => $value) {
                if (!isset($types[3][0]) || !isset($types[5][0])) {
                    continue;
                }

                $item = Teed::setContent($types[3][0], $types[5][0]);
                $file = str_replace( $types[0][0], $item, $file );
            }
        }

        if (preg_match_all("/(\{\-\- (setTemplate|includeFile|includePartial)\(('|\")(.*)('|\")\\) \-\-\})/U", $file, $types)>0) {
            foreach ($types[0] as $int => $value) {
                $item = Teed::{$types[2][0]}($types[4][0]);
                $file = str_replace($types[0][0], $item, $file );

                $response[] = [
                    'name' => $types[2][0],
                    'regex' => $types[0][0],
                    'value' => $file
                ];
            }

            if (!isset($types[2][0]) || !isset($types[4][0])) {
                continue;
            }
        }

        return $response;
    }

    public static function getContentsVariables($file)
    {
        if (preg_match_all("/(\{\-\- (getContent)\(('|\")(.*)('|\")\\) \-\-\})/U", $file, $types)>0) {
            foreach ($types[0] as $int => $value) {
                if (!isset($types[2][$int]) || !isset($types[4][$int])) {
                    continue;
                }

                $item = Teed::getContent($types[4][$int]);
                $file = str_replace( $value, $item, $file );
            }
        }

        return $file;
    }

    public static function renderBody($file)
    {
        $file = self::cacheFile( $file );

        if (preg_match("/(\{\-\- setContent\(('|\")body('|\")\) \-\-\})/U", $file) <= 0) {
            $file = "{-- setContent('body') --}{$file}{-- endcontent --}";
        }

        if (preg_match("/(\{\-\- setContent\((.*)\) \-\-\})/U", $file, $matches) > 0) {
            self::renderVariables( $file );
        }
    }

    public static function renderTemplate($file)
    {
        $file = self::cacheFile( $file );
        extract(Engine::all()['variables']);

        if (preg_match_all("/(\{\-\- (setContent|template|include|includePartial)\(('|\")(.*)('|\")\\) \-\-\})/U", $file, $types)>0) {
            foreach ($types[0] as $int => $type) {
                if (!isset($types[2][ $int ]) || !isset($types[3][ $int ])) {
                    continue;
                }

                $response = Teed::{$types[2][ $int ]}($types[4][ $int ]);
                $vars = self::renderVariables( $response );

                if (count($vars)) {
                    foreach ($vars as $value) {
                        $response = str_replace($value['regex'], $value['value'], $response );
                    }
                }

                $file = str_replace($types[0][ $int ], $response, $file );
            }
        }

        $file = self::getContentsVariables( $file );

        if (App::getEnv()->compress_output) {
            $file = preg_replace('/<!--([^\[|(<!)].*)/', '', $file);
            $file = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $file);
            $file = preg_replace('/\s{2,}/', '', $file);
            $file = preg_replace('/(\r?\n)/', '', $file);
        }

        eval("?>{$file}");
    }
}
