<?php

namespace api\controllers;

use api\model\Produto;

use util\Util;
use Curl;

class ProdutoController extends CrudController
{
	public function __construct()
	{
		parent::CrudController(new Produto());
	}

	public function create($params)
	{
		$params['preco'] = Util::formataPreco($params['preco']);

		return parent::create($params);
	}
	
	public function update($params)
	{
		$params['preco'] = Util::formataPreco($params['preco']);

		return parent::update($params);
	}

	

}
