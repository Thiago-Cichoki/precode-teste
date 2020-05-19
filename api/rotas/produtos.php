<?php

use api\App;
use api\controllers\ProdutoController;

$app->group("/produtos", function() use ($app) {
    $app->get("/{id}", function($request, $response, $args){
        $params = App::getRequestData($request, $args);        
        return (new ProdutoController())->read($params['id']);
    });
    
    $app->get("[/]", function(){
        return (new ProdutoController())->readAll();
    });

    $app->post("[/]", function($request, $response, $args){
        $params = App::getRequestPostData($request, $args);
        return (new ProdutoController())->create($params);
    });

    $app->put("/{id}", function($request, $response, $args){
        $params = App::getRequestPostData($request, $args);
        return (new ProdutoController())->update($params);
    });
    
    $app->delete("/{id}", function($request, $response, $args){
        $params = App::getRequestData($request, $args);
        return (new ProdutoController())->delete($params);
    });
});