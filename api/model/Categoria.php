<?php

namespace api\model;

use util\dao\CrudDao;
use util\Util;
use PDO;

class Categoria extends Model
{
    private $tableName = "categoria";

    public $id;
    public $idCategoriaPai;
    public $nome;
    

    public function __construct($conexao = null)
    {
        parent::Model($conexao, $this, $this->tableName, $this->whereClause);
    }

}
