<?php

use api\App;
use api\controllers\CategoriaController;

$app->group("/categoria", function() use ($app) {
    $app->get("/{id}", function($request, $response, $args){
        $params = App::getRequestData($request, $args);
        return (new CategoriaController())->read($params);
    });
    
    $app->get("[/]", function(){
        return (new CategoriaController())->readAll();
    });

    $app->post("[/]", function($request, $response, $args){
        $params = App::getRequestPostData($request, $args);
        return (new CategoriaController())->create($params);
    });

    $app->put("/{id}", function($request, $response, $args){
        $params = App::getRequestPostData($request, $args);
        return (new CategoriaController())->update($params);
    });
    
    $app->delete("/{id}", function($request, $response, $args){
        $params = App::getRequestData($request, $args);
        return (new CategoriaController())->delete($params);
    });
});