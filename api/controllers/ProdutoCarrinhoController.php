<?php

namespace api\controllers;

use api\model\Carrinho;
use api\model\ProdutoCarrinho;

use util\Util;
use Curl;

class ProdutoCarrinhoController extends CrudController
{
	public function __construct()
	{
		parent::CrudController(new ProdutoCarrinho());
	}

	public function create($params)
	{	
		if(!$this->model->lerItemCarrinho($params['idProduto'])){
			parent::create($params);
		} else {
			parent::update($params);
		}

		$this->atualizarCarrinho($params['idCarrinho']);
	}

	public function atualizarCarrinho($idCarrinho)
	{
		$produtos = $this->model->lerItensDoCarrinho($idCarrinho);
		$total = 0;

		foreach ($produtos as $produto) {
			(float) $total += $produto->quantidade * $produto->preco;
		}
		
		$carrinho = new Carrinho();
		$carrinho->update([
			'id' => $idCarrinho,
			'subTotal' => $total,
			'total' => $total
		]);
	}


	public function delete($params)
	{
		parent::delete(['id' => $params['id']]);
		$produtos = $this->model->lerItensDoCarrinho($params['idCarrinho']);
		$total = 0;

		foreach ($produtos as $produto) {
			(float) $total += $produto->quantidade * $produto->preco;
		}
		
		if(!$produtos){$total = '0.00';}

		$carrinho = new Carrinho();
		$carrinho->update([
			'id' => $params['idCarrinho'],
			'subTotal' => $total,
			'total' => $total
		]);
	}
}
