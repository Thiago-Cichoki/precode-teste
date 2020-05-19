<?php

namespace api\model;

use util\dao\CrudDao;
use util\Util;
use PDO;

class Carrinho extends Model
{
    private $tableName = "carrinho";

    public $id;
    public $subTotal;
    public $valorFrete;
    public $total;
    public $created_at;
    

    public function __construct($conexao = null)
    {
        parent::Model($conexao, $this, $this->tableName, $this->whereClause);
    }

}
