<?php

/**
 * Created by PhpStorm.
 * User: Master
 * Date: 16/01/2020
 * Time: 12:55
 */

namespace api\model;

use util\dao\CrudDao;
use util\interfaces\ICrud;

abstract class Model implements ICrud
{

    protected $dao;

    public function Model($conexao = null, Model $model, $tableName)
    {
        $dao = new CrudDao();
        $dao->CrudDao($conexao, $model);
        $dao->setTableName($tableName);
        $this->setDao($dao);
    }

    public function paramsToObject($params)
    {
        foreach ($this as $key => $value) {
            if (isset($params[$key])) {
                $this->$key = $params[$key];
            }
        }
    }

    /**
     * @param mixed $dao
     */
    public function setDao($dao)
    {
        $this->dao = $dao;
    }

    /**
     * @return mixed
     */
    public function getDao()
    {
        return $this->dao;
    }

    public function create($params)
    {
        return $this->dao->create($params);
    }

    public function delete($id)
    {
        return $this->dao->delete($id);
    }

    public function readAll()
    {
        return $this->dao->readAll();
    }

    public function read($id)
    {   
        return $this->dao->read($id);
    }

    public function update($params)
    {
        return $this->dao->update($params);
    }
}
