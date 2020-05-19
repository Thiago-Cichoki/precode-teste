<?php

use api\App;
use api\controllers\CarrinhoController;
use api\controllers\ProdutoCarrinhoController;

$app->group("/carrinho", function() use ($app) {
    $app->get("/{id}", function($request, $response, $args){
        $params = App::getRequestData($request, $args);
        return (new CarrinhoController())->read($params['id']);
    });
    
    $app->get("[/]", function(){
        return (new CarrinhoController())->readAll();
    });

    $app->post("[/]", function($request, $response, $args){
        $params = App::getRequestPostData($request, $args);
        return (new CarrinhoController())->create($params);
    });

    $app->put("/{id}", function($request, $response, $args){
        $params = App::getRequestPostData($request, $args);
        return (new CarrinhoController())->update($params);
    });
    
    $app->delete("/{id}", function($request, $response, $args){
        $params = App::getRequestData($request, $args);
        return (new ProdutoCarrinhoController())->delete($params);
    });
});