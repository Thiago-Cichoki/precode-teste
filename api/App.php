<?php
/**
 * Created by PhpStorm.
 * User: Master
 * Date: 16/01/2020
 * Time: 11:58
 */

namespace api;

require_once "../vendor/autoload.php";
use \Slim\Container;

class App
{
    private $app;

    public function __construct(){

        $error_disable = 1;
        if ($error_disable) {
            error_reporting(E_ERROR | E_PARSE);
        } else {
            error_reporting(E_ALL^E_NOTICE);
        }

        $app = new \Slim\App([
            'settings' => ['displayErrorDetails' => true],
            'determineRouteBeforeAppMiddleware' => true,
        ]);


        $container = $app->getContainer();

        $container['session'] = function (Container $container) {
            return new Session();
        };

        $app->group("", function() use ($app) {
            require "rotas/categorias.php";
            require "rotas/produtos.php";
            require "rotas/carrinho.php";
            require "rotas/arquivo.php";
        });

        $this->app = $app;
    }

    public function get(){
        return $this->app;
    }

    public static function getRequestData($request, $args){
        $params = array_merge($request->getQueryParams(), $args);
        return $params;
    }
    public static function getRequestPostData($request, $args, $getFile = false) {
        $params = array_merge($request->getParams(), $args);
        $params = array_merge($params, $_FILES);
        
        return $params;
    }

}