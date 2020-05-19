<?php

namespace api\model;

use util\dao\CrudDao;
use util\Util;
use PDO;

class Produto extends Model
{
    private $tableName = "produto";

    public $id;
    public $idCategoria;
    public $nome;
    public $descricao;
    public $preco;
    public $ativo;
    public $urlFotoProduto;
    public $quantidade;
    

    public function __construct($conexao = null)
    {
        parent::Model($conexao, $this, $this->tableName, $this->whereClause);
    }

    public function readAll()
    {
        $query = "SELECT $this->tableName.*, c.nome as categoria FROM $this->tableName 
                  INNER JOIN categoria as c ON c.id = $this->tableName.idCategoria;";

        $stm = $this->dao->prepare($query);

        if(!$stm->execute())
            return false;
        
        $produtos = $stm->fetchAll(PDO::FETCH_OBJ);

        foreach ($produtos as $produto) {
            $produto->preco = number_format($produto->preco, 2, ',', '.');
        }

        return json_encode($produtos);
    }

    public function read($id)
    {   
        $query = "SELECT $this->tableName.*, c.nome as categoria FROM $this->tableName 
                  INNER JOIN categoria as c ON c.id = $this->tableName.idCategoria
                  WHERE $this->tableName.id = :id;";

        $stm = $this->dao->prepare($query);

        $stm->bindValue(':id', $id, PDO::PARAM_INT);

        if(!$stm->execute())
            return false;
        
        $produto = $stm->fetch(PDO::FETCH_OBJ);

        $produto->preco = number_format($produto->preco, 2, ',', '.');

        return json_encode($produto);
    }

}
