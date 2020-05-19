<?php

namespace api;

use util\Util;

session_start();

require_once "../vendor/autoload.php";

header("Cache-Control: private, no-cache, must-revalidate, max-age=30, proxy-revalidate, s-maxage=0"); 
header("Expires: 0");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");

$app = (new App())->get();

$app->get("/", function(){
    echo "<h4>API Teste Procode Thiago Miranda Cichoki</h4>";
});

$app->run();
