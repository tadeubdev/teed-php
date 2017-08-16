<?php

class Files
{

    public static function getData($file_name, $other = null)
    {
        if (!$other) {
            if (!Dir::getData()) {
                return;
            }

            $file_name = Dir::getData($file_name);
        }

        return self::getFile( $file_name, false, true );
    }

    public static function getFile($file_name, $text = null, $vars = null)
    {

        try {
            if (empty($file_name) || !file_exists($file_name) || !is_file($file_name)) {
                throw new TeedException();
            }
        } catch (TeedException $e) {
            $e->errorMessage( 'file-not-found', $file_name );
        }

        if (!$text && isset( explode( '.', $file_name )[1] )) {
            if (pathinfo($file_name)['extension'] == 'json') {
                return json_decode( file_get_contents( $file_name ) );
            } elseif (pathinfo($file_name)['extension'] == 'php') {
                ob_start();

                if ($vars) {
                    $vars = include( $file_name );
                    ob_get_clean();
                    return String::toObject( $vars );
                } else {
                    include( $file_name );
                    return ob_get_clean();
                }
            }
        }

        return file( $file_name );
    }

    public static function putFile($file, $data, $type = 'a+')
    {
        if (is_array($data)||is_object($data)) {
            $data = json_encode($data);
        }

        $file = fopen($file, $type);
        fwrite($file, $data);
        fclose($file);
        return;
    }

    public static function getPaths($dir)
    {
        $result = [];
        $cdir = scandir($dir);

        foreach ($cdir as $key => $value) {
            if ($value=='.git') {
                continue;
            }

            if (!in_array($value, [".",".."])) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = self::get_paths($dir . DIRECTORY_SEPARATOR . $value);
                } else {
                    $result[] = $value;
                }
            }
        }

        return $result;
    }

    public static function createPath($path_name)
    {

        $pathinfo = pathinfo($path_name);

        if (isset( $pathinfo['extension'] ) && in_array( $pathinfo['extension'], ['html','php','json','css'] )) {
            $path_name = $pathinfo['dirname'];
        }

        $path_to = '';

        foreach (explode( '/', $path_name ) as $value) {
            $value = str_replace('\\', '/', $value);
            $path_to .= "{$value}/";
            if (!is_dir($path_to)) {
                mkdir( $path_to);
            }
        }
    }

    public static function removeDir($dirname)
    {

        if (is_dir($dirname)) {
            $dir_handle = opendir($dirname);
        }

        if (!$dir_handle) {
            return false;
        }

        while ($file = readdir($dir_handle)) {
            chmod("{$dirname}/{$file}", 0777);

            if ($file != "." && $file != "..") {
                if (!is_dir("{$dirname}/{$file}")) {
                    unlink("{$dirname}/{$file}");
                } else {
                    self::remove_dir("{$dirname}/{$file}");
                }
            }
        }

        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }
}
