<?php

namespace util\dao;

use util\Util;
use PDO;

abstract class BaseDao
{

    private $conexao;
    private $user;
    private $pw;
    private $dns;
    public $isTransaction = false;
    protected $tableName;

    public function BaseDao($conexao = null){

        if ($conexao == null) {

            $mysqlConfig = Util::getMysqlConfig();

            $this->user = $mysqlConfig['user'];
            $this->pw = $mysqlConfig['password'];
            $this->host = $mysqlConfig['host'];
            $this->dbName = $mysqlConfig['dbName'];
            $this->dns = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;

            try {
                $this->conexao = new PDO($this->dns, $this->user, $this->pw, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (\Exception $e) {
                print_r($e);
                $this->null;
                throw new \Exception("Falha na conexão com o banco de dados. Por favor, tente novamente.");

            }
        } else {
            $this->conexao = $conexao;
        }

    }

    /**
     * @param mixed $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return mixed
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    public function getConexao() {
        return $this->conexao;
    }

    public function errorInfo() {
        return $this->conexao->errorInfo();
    }

    public function lastInsertId() {
        return $this->conexao->lastInsertId();
    }

    public function prepare($q) {
        return $this->conexao->prepare($q);
    }

    public function closeConexao() {
        $this->conexao = null;
    }

    public function beginTransaction() {
        $this->conexao->beginTransaction();
        $this->isTransaction = true;
    }

    public function commit() {
        $this->conexao->commit();
        $this->isTransaction = false;
    }

    public function rollBack() {
        $this->conexao->rollBack();
        $this->isTransaction = false;
    }

    public function query($q) {
        return $this->conexao->query($q);
    }

}