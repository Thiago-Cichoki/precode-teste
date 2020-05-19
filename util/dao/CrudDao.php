<?php

/**
 * Created by PhpStorm.
 * User: Master
 * Date: 16/01/2020
 * Time: 19:27
 */

namespace util\dao;


use util\interfaces\ICrud;
use api\model\Model;
use PDO;

class CrudDao extends BaseDao implements ICrud
{
    private $model;

    public function CrudDao($conexao = null, Model $model)
    {
        parent::BaseDao($conexao);
        $this->model = $model;
    }

    public function create($params)
    {
        $this->model->paramsToObject($params);
        
        unset($this->model->id);

        $colunas = [];
        $valores = [];

        $query = "INSERT INTO $this->tableName (";

        foreach ($this->model as $key => $value) {
            if (!empty($value)) {
                $colunas[] = $key;
                $valores[] = $value;
            }
        }

        for ($i = 0; $i < count($colunas); $i++) {
            if (isset($valores[$i])) {
                $query .= ($colunas[$i] == end($colunas)) ?  $colunas[$i] . ")" : $colunas[$i] . ", ";
            }
        }

        $query .= " VALUES (";

        for ($i = 0; $i < count($colunas); $i++) {
            if (isset($valores[$i])) {
                $query .= ($colunas[$i] == end($colunas)) ? ":" . $colunas[$i] . ");" : ":" . $colunas[$i] . ", ";
            }
        }
        
        $statment = $this->prepare($query);

        for ($i = 0; $i < count($colunas); $i++) {
            if (isset($valores[$i])) {
                $statment->bindValue((":" . $colunas[$i]), $valores[$i], (gettype($valores[$i]) == 'integer') ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
        }
        if (!$statment->execute()) {
            throw new \Exception("Failed to insert data into database");
            return;
        }

        $this->model->id = $this->lastInsertId();

        return true;
    }

    public function read($id)
    {
        $query = "SELECT * FROM $this->tableName WHERE id = :id";
        $statment = $this->prepare($query);
        $statment->bindValue(":id", $id, PDO::PARAM_INT);
        if (!$statment->execute()) {
            throw new \Exception("Failed to return table data");
            return;
        }
        $result = $statment->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            return false;
        }
        return json_encode($result);
    }

    public function readAll()
    {
        $query = "SELECT * FROM $this->tableName;";
        $statment = $this->prepare($query);
        if (!$statment->execute()) {
            throw new \Exception("Failed to return table data");
            return;
        }
        $result = $statment->fetchAll(PDO::FETCH_OBJ);
        return json_encode($result);
    }

    public function update($params)
    {
        $this->model->paramsToObject($params);
        $colunas = [];
        $valores = [];
        $id = $this->model->id;

        unset($this->model->id);

        $query = "UPDATE $this->tableName SET ";

        foreach ($this->model as $key => $value) {
            if (!empty($value)) {
                $colunas[] = $key;
                $valores[] = $value;
            }
        }

        for ($i = 0; $i < count($colunas); $i++) {
            if (isset($valores[$i])) {
                $query .= ($colunas[$i] == end($colunas)) ?  $colunas[$i] . " = :" . $colunas[$i] . "" : $colunas[$i] . " = :" . $colunas[$i] . ", ";
            }
        }

        $query .= " WHERE id = :id;";
        
        $statment = $this->prepare($query);

        $statment->bindValue(":id", $id, PDO::PARAM_INT);

        for ($i = 0; $i < count($colunas); $i++) {
            if (isset($valores[$i])) {
                $statment->bindValue((":" . $colunas[$i]), $valores[$i], (gettype($valores[$i]) == 'integer') ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
        }

        if (!$statment->execute()) {
            throw new \Exception("Falha ao alterar os dados.");
            return;
        }

        return true;
    }

    public function delete($id)
    {
        $this->model->paramsToObject($id);

        $query = "DELETE FROM $this->tableName WHERE id = :id;";
        
        $statment = $this->prepare($query);

        $statment->bindValue(":id", $this->model->id, PDO::PARAM_INT);

        if (!$statment->execute()) {
            throw new \Exception("Falha ao deletar os dados.");
            return;
        }

        return true;
    }
}
