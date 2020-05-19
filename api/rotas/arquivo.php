<?php

use api\App;
use api\controllers\ArquivoController;

$app->post("/arquivo", function($request, $response, $args){
    $params = App::getRequestPostData($request, $args);
    return (new ArquivoController())->upload($params['file']);
});