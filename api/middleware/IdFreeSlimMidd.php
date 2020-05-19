<?php
/**
 * Created by PhpStorm.
 * User: Thiago Cichoki
 * Date: 10/10/2019
 * Time: 08:13
 */

namespace api\middleware;

use Curl\Curl;
use api\controllers\UsuarioController;
use util\Util;

class IdFreeSlimMidd
{
    /*
    * @param $request
    * @param $response
    * @param $next
    * @return mixed
    * Example: curl -X POST http://denudo.localhost/web/rest/events/1 -H "Authorization: Bearer ece68d6fafacf55fcea9b36860209fdfa16de2a3" -d "method=shareReviewForm"
    */

    function __invoke($request, $response, $next) {

        if(!Util::isMiddlewareEnabled("auth")){ $response = $next($request, $response); return $response; }

        $headers = $request->getHeaders("Authorization");

        $access_token = $this->getBearerToken($headers);

        if($access_token){ setcookie("access_token", $access_token); }


        $verified_token = OA2ClientSide::checkAccessToken($access_token);

        if ($verified_token === false) { return $response->withStatus(401);}
        
        if(!$_SESSION["logged_in"]){ self::login($verified_token["user_id"]); }
        
        $response = $next($request, $response);
        return $response;
        
    }
    
    public static function login($user_id){
        
        
        $uDao = new UsuarioController();
        $user = $uDao->read([], [], $user_id);
        $user = json_decode($user);

        if($user){

            $_SESSION["logged_in"] = true;

            $_SESSION["user_id"] = $user->id;
        }

    }

    function getBearerToken($headers) {
        if(empty($headers) || !$headers["HTTP_AUTHORIZATION"] || !$headers["HTTP_AUTHORIZATION"][0]){ return null; }
        // print_r($headers["HTTP_AUTHORIZATION"]);exit;
        if (preg_match('/Bearer\s(\S+)/', $headers["HTTP_AUTHORIZATION"][0], $matches)) {return $matches[1]; }


        return null;

    }
}