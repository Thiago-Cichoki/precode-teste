<?php

namespace api\controllers;

use api\model\Carrinho;
use api\model\ProdutoCarrinho;
use util\Util;
use Curl;

class CarrinhoController extends CrudController
{
	public function __construct()
	{
		parent::CrudController(new Carrinho());
	}

	public function create($params)
	{
		if (isset($params['action']) && $params['action'] == 'adicionarProduto' && isset($params['idCarrinho'])) {
			return (new ProdutoCarrinhoController)->create($params);
		}

		parent::create(['total' => '0.00', 'valorFrete' => '0.00', 'subTotal' => '0.00']);
		$carrinho = parent::read($this->model->id);
		$carrinho = json_decode($carrinho);

		return json_encode($carrinho);
	}

	public function read($id)
	{
		$carrinho = parent::read($id);
		$carrinho = json_decode($carrinho);


		$produtoCarrinho = new ProdutoCarrinho();
		$produtos = $produtoCarrinho->lerItensDoCarrinho($carrinho->id);

		$carrinho->produtos = $produtos;

		return json_encode($carrinho);
	}

	public function update($params)
	{
		$produtoCarrinho = new ProdutoCarrinho();
		foreach ($params['produtos'] as $produto) {
			$produtoRecuperado = $produtoCarrinho->lerItemCarrinho($produto['produtoId']);
			
			if ($produtoRecuperado) {
				$produtoCarrinho->update(['quantidade' => $produto['quantidade'], 'idProduto' => $produtoRecuperado->idProduto]);
			}
		}

		$produtos = $produtoCarrinho->lerItensDoCarrinho($params['id']);
		$total = 0;

		foreach ($produtos as $produto) {
			(float) $total += $produto->quantidade * $produto->preco;
		}

		parent::update([
			'id' => $params['id'],
			'subTotal' => $total,
			'total' => $total
		]);
	}	
}
