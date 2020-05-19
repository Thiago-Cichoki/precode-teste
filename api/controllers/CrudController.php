<?php

/**
 * Created by PhpStorm.
 * User: Master
 * Date: 16/01/2020
 * Time: 20:08
 */

namespace api\controllers;

use api\model\Model;
use util\interfaces\ICrud;

abstract class CrudController implements ICrud
{
    protected $model;

    public function CrudController(Model $model)
    {
        $this->setModel($model);
    }

    /**
     * @param mixed $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    public function create($params)
    {
        return $this->model->create($params);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function readAll()
    {
        return $this->model->readAll();
    }

    public function read($id)
    {
        return $this->model->read($id);
    }

    public function update($params)
    {
        return $this->model->update($params);
    }
}
