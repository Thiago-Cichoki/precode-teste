<?php

namespace api\Middleware;

use api\Controllers\UsuarioController;
use Curl\Curl;
use util\Util;

require "../config/auth_config.php";

class OA2ClientSide {

    const ID_EXPIRES_IN = 36000;
    const ACCESS_EXPIRES_IN = 36000;
    const REFRESH_EXPIRES_IN = 1728000;
    const LAST_URI = '';

    public static function configRefreshTokenRequest($refresh_token){
        $data['grant_type'] = 'refresh_token';
        $data['refresh_token'] = $refresh_token;

        return $data;
    }



    public static function requestRefreshToken($data){

        $ch = \curl_init();
        curl_setopt($ch, CURLOPT_URL, PRECODE_REFRESH_TOKEN_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_USERPWD, self::CLIENT_USERPWD);

        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }

    public static function configTokenRequest($params){
        $data['grant_type'] = 'authorization_code';
        $data['code'] = $params['code'];
        $data['redirect_uri'] = $params['redirect_uri'];

        return $data;
    }

    public static function checkIdToken() {

        if (isset($_COOKIE['id_token'])) {

            $id_token = $_COOKIE['id_token'];
            $json_id_token = self::requestUserInfo($id_token);
            $decoded_id_token = json_decode($json_id_token, true);

            if ($decoded_id_token !== null && isset($decoded_id_token['sub'])) { return $decoded_id_token; }
            else { return false; }

        } else { return false; }
    }

    public static function checkAccessToken($token = null) {
        if (!isset($_COOKIE['access_token']) && !$token) { return false; }

        $access_token = $token ? $token : $_COOKIE["access_token"];
        $json_token = self::isValidToken($access_token);
        $verified_token = json_decode($json_token, true);

        if ($verified_token === null || !isset($verified_token['access_token'])) { return false; }

        return $verified_token;

    }

    public static function checkRefreshToken() {
        if (isset($_COOKIE['refresh_token'])) {
            return $_COOKIE['refresh_token'];
        } else {
            return false;
        }
    }

    public static function configUserSession($loginResult){
        $user_session = json_decode($loginResult, true);

        setcookie(
            'access_token', $user_session['access_token'], time() + self::ACCESS_EXPIRES_IN, '/', "", false, false
        );
        setcookie(
            'id_token', $user_session['id_token'], time() + self::ID_EXPIRES_IN, '/', "", false, false
        );
        setcookie(
            'refresh_token', $user_session['refresh_token'], time() + self::REFRESH_EXPIRES_IN, '/', "", false, false
        );

    }

    public static function readSlimBearerToken($slimRequest) {
        $header = $slimRequest->getHeader('Authorization');
        $token = "";
        if ($header !== null && isset($header[0])) {
            $bearer = explode(' ', $header[0]);
            if (isset($bearer[1]))
                $token = $bearer[1];
        }
        return $token;
    }

    public static function groupSlimRequestParams($slimRequest)
    {

        $params = array_merge(
            (array) $slimRequest->getQueryParams(), (array) $slimRequest->getParsedBody()
        );


        $network = Util::getNetwork();
        $isDevelopmentMode = Util::isDevelopmentMode();


        $params['redirect_uri'] =  (($network == "local") ? $slimRequest->getUri()->getScheme() : "https") . '://' . $slimRequest->getUri()->getHost();

        $params['redirect_uri'] .= "";

        $params['redirect_uri'] .=  $slimRequest->getUri()->getBasePath();

        $params['redirect_uri'] .= "/" . $slimRequest->getUri()->getPath();


        return $params;

    }

    public static function requestUserInfo($id_token, $scopes = []) {

        $scopeStr = implode("+", $scopes);
        $ch = curl_init(PRECODE_REQUEST_USERINFO_URL . $scopeStr);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array("Content-Type: application/json", "Authorization: Bearer " . $id_token);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    public static function isValidToken($token) {
        $ch = curl_init(PRECODE_TOKEN_VALIDATION_URL);
        $headers = array("Content-Type: application/x-www-form-urlencoded", "Authorization: Bearer " . $token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public static function requestOpenIdSession($data) {
        return self::requestAccessToken($data);
    }

    public static function requestAccessToken($data) {
        $data['client_id'] = '0oahvtywnhwMIYQul0h7';
        $data['client_secret'] = 'PUw7NVwzLNHErt1xn4525pFcajicV52EmJKpTtKs';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, PRECODE_REFRESH_TOKEN_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_POST, 1);


        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


        $result = curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $result;
    }

    public static function configAuthCodeOpenIdRequest($params) {
        if(!isset($params['last_uri'])){
            $params['last_uri'] = self::LAST_URI;
        }

        $_SESSION['last_uri'] = $params['last_uri'];

        if (!isset($params['scope'])) {
            $params['scope'] = '';
        }

        $hasOpenId = strpos($params['scope'], 'openid');
        $hasProfile = strpos($params['scope'], 'profile');

        $scope = '';
        if ($hasOpenId === false) {
            $scope .= 'openid ';
        }

        if ($hasProfile === false) {
            $scope .= 'profile ';
        }

        $scope = $scope . trim($params['scope']);
        $params['scope'] = trim($scope);

        $data = self::configAuthCodeRequest($params);

        $_SESSION['nonce'] = base64_encode(random_bytes(14));
        $data['nonce'] = $_SESSION ['nonce'];
        return $data;
    }

    public static function configAuthCodeRequest($params) {
        $data['state'] = base64_encode(random_bytes(14));
        $_SESSION['state'] = $data['state'];
        $data['client_id'] = '0oahvtywnhwMIYQul0h7';
        $data['redirect_uri'] = $params['redirect_uri'];
        $data['response_type'] = 'code';
        $data['grant_type'] = 'authorization_code';
        $data['scope'] = $params['scope'];
        return $data;
    }

    public static function clearCookies(){

        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 1000, '/', "");
                setcookie($name, '', time() - 1000, '/', "");
            }
        }
    }

    public static function clearSession() {

        $_SESSION = [];
        session_unset();
        session_destroy();

    }

    public static function configDeniedResponse($request, $response, $args = []) {
        $params = array_merge((array) $request->getBody(), (array) $request->getQueryParams());
        /**
         * When using a Javascript framework like MooTools or jQuery to execute an XMLHttpRequest, the XMLHttpRequest will usually be sent with a X-Requested-With HTTP header. The Slim application will detect the HTTP request’s X-Requested-With header and flag the request as such.
         * If for some reason an XMLHttpRequest cannot be sent with the X-Requested-With HTTP header, you can force the Slim application to assume an HTTP request is an XMLHttpRequest by setting a GET, POST, or PUT parameter in the HTTP request named “isajax” with a truthy value.
         * Source: http://docs.slimframework.com/request/xhr/
         */


        if ($request->isXhr() || !empty($params["isajax"])) {

            $response = $response->withStatus(403, "Access denied.");
            $response = $response->write(json_encode(["status" => 403, "message" => "Access denied (auth)."]));
            return $response;

        } else {

            $params["redirect_uri"] = PRECODE_OA2LOGIN_PATH;
            $last_uri = $request->getHeader('HTTP_REFERER');
            $last_uri = array_shift($last_uri);
            $last_uri = parse_url($last_uri);
            
            $_SESSION['last_uri'] = $last_uri['path'];
            $params["last_uri"] = $last_uri['path'];

            $data = http_build_query(OA2ClientSide::configAuthCodeOpenIdRequest($params));

            $redirectUrl = (!empty($args) && $args['page_login'] == 'sign_up') ? PRECODE_REGISTER_URL : PRECODE_REQUEST_AUTHCODE_URL;
            
            $response = $response->withRedirect($redirectUrl . $data, 302);
            return $response;
        }
    }

    public static function configRegisterResponse($request, $response, $loginResult) {

        $params = array_merge((array) $request->getBody(), (array) $request->getQueryParams());
        if ($request->isXhr() || !empty($params["isajax"])) {

            $response = $response->withStatus(403, "Access denied (you must register on the Resource API).");
            $response = $response->write(json_encode(["status" => 403, "message" => "Access denied (you must register on the Resource API)."]));
            return $response;

        } else {

            $decodedLoginResult = json_decode($loginResult);

            $oa2_user_json = \api\middleware\OA2ClientSide::requestUserInfo($decodedLoginResult->id_token, ["userinfo.id", "userinfo.email", "userinfo.nome", "userinfo.cpf", "userinfo.sexo", "userinfo.tipo"]);
            $oa2_user = json_decode($oa2_user_json);


            $uCtrl = new UsuarioController();
            $result = json_decode($uCtrl->create([
                "nome" => $oa2_user->nome,
                "phone" => $oa2_user->phone_number,
                "oa2_email" => $oa2_user->email,
                'role_name' => (isset($oa2_user->cnpj) && $oa2_user->cnpj !== '') ? "company-view" : "client-view",
                'is_company' => (isset($oa2_user->cnpj) && $oa2_user->cnpj !== '') ? true : false,
                "cnpj" => $oa2_user->cnpj
            ]));

            $_SESSION['user_id'] = $result->id;

            if($result->status != 200){ print json_encode(["error_message" => $result->message]); return; }


            if ($result->obj->role_name == "company-view") {
                return $response->withRedirect(\util\Util::getApiPath() . "/my-company-account", 302);
            } else {
                return $response->withRedirect(\util\Util::getApiPath() . "/minha-conta", 302);
            }

        }
    }
}