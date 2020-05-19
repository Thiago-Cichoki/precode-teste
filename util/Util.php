<?php

/**
 * Created by PhpStorm.
 * User: Master
 * Date: 16/01/2020
 * Time: 12:56
 */

namespace util;

define("DIR_BASE", dirname(__FILE__) . '/../');
define("DIR_CONFIG",   DIR_BASE . 'config/');
define("DIR_API",   DIR_BASE . 'api/');
define("DIR_WEB",   DIR_BASE . 'web/');
define("DIR_VENDOR",   DIR_BASE . 'vendor/');



class Util
{
    public static function getNameProject()
    {
        $configs = Util::getConfigs();
        return $configs['name'];
    }

    public static function getUserId()
    {
        return $_SESSION['user_id'];
    }

    public static function getConfigs()
    {
        return Util::jsonToArray(DIR_CONFIG . "config.json");
    }

    public static function getFlickrApiKey()
    {
        $configs = Util::getConfigs();
        return  $configs['FlickrApiKey'];
    }

    public static function getFlickrApiSecret()
    {
        $configs = Util::getConfigs();
        return  $configs['FlickrApiSecret'];
    }

    public static function getPathSite()
    {
        $configs = Util::getConfigs();
        return  $configs['pathSite'];
    }

    public static function getPathApi()
    {
        $configs = Util::getConfigs();
        return  $configs['pathApi'];
    }
    public static function getPathAdmin()
    {
        $configs = Util::getConfigs();
        return  $configs['pathAdmin'];
    }

    public static function formataPreco($preco)
    {
        return number_format(str_replace(",", ".", str_replace(".", "", $preco)), 2, '.', '');
    }

    public static function getPathAuth()
    {
        $configs = Util::getConfigs();
        return  $configs['pathAuth'];
    }

    public static function getNetwork()
    {
        $config = Util::getConfigs();
        return $config['network']; //local or live
    }

    public static function getAuthenticationHash()
    {
        $config = Util::getConfigs();
        return $config['AuthenticationHash'];
    }

    public static function isMiddlewareEnabled($name)
    {
        $configs = self::getConfigs();
        return !self::isDevelopmentMode() || $configs["middleware"][$name] === "on";
    }

    public static function convertDate($date)
    {
        return date("d/m/Y", strtotime($date));
    }


    public static function getMysqlConfig()
    {
        $databaseConfig = include(DIR_CONFIG . 'database.php');

        return $databaseConfig;
    }

    public static function getSendGridAPIKey()
    {
        $apikey = include(DIR_CONFIG . 'apikeys.php');
        return $apikey['sendgrid'];
    }


    public static function isDevelopmentMode()
    {
        $config = Util::getConfigs();
        return $config['mode'] === 'dev';
    }

    public static function jsonToArray($path)
    {
        return json_decode(file_get_contents($path), true);
    }

    public static function jsonToList($path)
    {
        return json_decode(file_get_contents($path));
    }
}
