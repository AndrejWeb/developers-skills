<?php
//helper functions
namespace App\Helpers;

defined('APP_NAME') || exit('No direct access allowed.');

class Functions
{
    public static function parseParams($params = null)
    {
        $params = explode( '/', $params );
        $params = array_filter($params);
        $return_params = array();
        if($params) {
            for($i = 0; $i < count($params); $i+=2) {
                $return_params[$params[$i]] = (isset($params[$i+1])) ? $params[$i+1] : '';
            }
        }
        return $return_params;
    }

    public static function arrayFlatten($array)
    {
        $return = array();
        array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
        return $return;
    }

    public static function createToken()
    {
        if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
            return bin2hex(random_bytes(32));
        }
        else if(version_compare(PHP_VERSION, '5.6.0') >= 0) {
            return bin2hex(openssl_random_pseudo_bytes(32));
        }
        else {
            exit('It appears your PHP version is below the minimum version required for this app. Please upgrade your PHP version to at least 5.6.0.');
        }
    }

    public static function tokenExpired($token, $token_lifetime)
    {
        if(isset($token['created_at']) && (time() - $token['created_at']) <= $token_lifetime)
            return false;

        return true;
    }
}
