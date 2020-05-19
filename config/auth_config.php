<?php


use util\Util;

$configs = [
    "apiPath" => "http://127.0.0.1/precode/api",
    "authPath" => "http://127.0.0.1/precode/auth",
    "containerPath" => "http://127.0.0.1/precode/auth",
];

DEFINE("PRECODE_OA2LOGIN_PATH", $configs["apiPath"] . "/receive_login");
DEFINE("PRECODE_REGISTER_PATH", $configs["apiPath"] . "/sign_up");
DEFINE("PRECODE_RECEIVE_NEW_USER", $configs["apiPath"] . "/receive-new-user");
DEFINE("PRECODE_SEND_NEW_USER", $configs["apiPath"] . "/send-new-user/");

DEFINE("PRECODE_TEST_REQUEST", $configs["containerPath"] . "/request_test");


DEFINE("PRECODE_REQUEST_AUTHCODE_URL", $configs["authPath"] . "/request_authcode?");
DEFINE("PRECODE_REFRESH_TOKEN_URL", $configs["containerPath"] . "/refresh_token");
DEFINE("PRECODE_REQUEST_USERINFO_URL", $configs["containerPath"] . "/userinfo?scope=");
DEFINE("PRECODE_TOKEN_VALIDATION_URL", $configs["containerPath"] . "/is_valid_token");
DEFINE("PRECODE_REQUEST_TOKEN_URL", $configs["containerPath"] . "/request_token");
DEFINE("PRECODE_REVOKE_TOKEN_URL", $configs["containerPath"] . "/revoke_token");

DEFINE("PRECODE_COMPLETE_REGISTRATION_URL", $configs["authPath"] . "/update-user-pw");
DEFINE("PRECODE_REGISTER_URL", $configs["authPath"] . "/sign_up?");
DEFINE("PRECODE_TEAM_CREATE_URL", $configs["authPath"] . "/create-team");
DEFINE("PRECODE_CHECK_EMAIL", $configs["authPath"] . "/check_email");


return $configs;