<?php

namespace api\model;

use util\dao\CrudDao;
use util\Util;
use PDO;

class ProdutoCarrinho extends Model
{
    private $tableName = "produtoCarrinho";

    public $id;
    public $idProduto;
    public $idCarrinho;
    public $quantidade;


    public function __construct($conexao = null)
    {
        parent::Model($conexao, $this, $this->tableName, $this->whereClause);
    }

    public function lerItensDoCarrinho($idCarrinho)
    {
        $query = "SELECT $this->tableName.quantidade, $this->tableName.id, produto.preco, produto.nome, produto.urlFotoProduto, produto.id as produtoId FROM $this->tableName
                  INNER JOIN produto on produto.id = $this->tableName.idProduto
                  WHERE $this->tableName.idCarrinho = :idCarrinho;";

        $stm = $this->dao->prepare($query);

        $stm->bindValue(':idCarrinho', $idCarrinho, PDO::PARAM_INT);

        if (!$stm->execute())
            return false;

        $produtos = $stm->fetchAll(PDO::FETCH_OBJ);

        return $produtos;
    }

    public function lerItemCarrinho($idProduto)
    {
        $query = "SELECT $this->tableName.* FROM $this->tableName
                  WHERE $this->tableName.idProduto = :idProduto;";

        $stm = $this->dao->prepare($query);

        $stm->bindValue(':idProduto', $idProduto, PDO::PARAM_INT);

        if (!$stm->execute())
            return false;

        $produto = $stm->fetch(PDO::FETCH_OBJ);

        return $produto;
    }

    public function update($params)
    {
        $query = "UPDATE $this->tableName SET
                  quantidade = :quantidade
                  WHERE id = (SELECT id FROM $this->tableName WHERE idProduto = :idProduto);";

        $stm = $this->dao->prepare($query);

        $stm->bindValue(":quantidade", $params['quantidade'], PDO::PARAM_INT);
        $stm->bindValue(":idProduto", $params['idProduto'], PDO::PARAM_INT);

        if (!$stm->execute() || !$stm->rowCount()) {
            return false;
        }

        return true;
    }
}
