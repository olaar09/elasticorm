<?php

/**
 * Description of Mysql
 *
 * @author olaar
 */
require 'ElasticOrm/DbCommands.php';
require 'ElasticOrm/TableConfigInterface.php';
require 'ElasticOrm/MysqlQueries.php';

class MysqlCommands implements DbCommands, TableConfigInterface {

    use MysqlQueries;

    private $connection = null;
    private $table;
    private $pk;
    private $selectColumns = [];
    private $whereCondition;
    private $whereParameters;

    public function __construct($servername, $username, $dbName, $password) {
        $this->connection = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
        $this->pk = "id";
    }

    public function find() {
        $queryResult = $this->selectQuery($this, $this->whereCondition, $this->whereParameters, $this->selectColumns)->fetch();
        return (object) $queryResult;
    }

    public function findAll() {
        $queryResults = $this->selectQuery($this, $this->whereCondition, $this->whereParameters, $this->selectColumns)->fetchAll();
        foreach ($queryResults as $queryResult) {
            $result[] = (object) $queryResult;
        }

        return $result;
    }

    public function delete() {
        return $this->deleteQuery($this, $this->whereCondition, $this->whereParameters)->rowCount();
    }

    public function deleteByAttributes(array $attributes) {
        return $this->deleteQuery($this, $attributes, [], true)->rowCount();
    }

    public function deleteByPk($pk) {
        return (object) $this->deleteQuery($this, "$this->pk = ?", [$pk])->rowCount();
    }

    public function findByAttributes($attributes) {
        return (object) $this->selectQuery($this, $attributes, [], true)->fetch();
    }

    public function findAllByAttributes($attributes) {
        $queryResults = $this->selectQuery($this, $attributes, [], true)->fetchAll();
        foreach ($queryResults as $queryResult) {
            $result[] = (object) $queryResult;
        }

        return $result;
    }

    public function findByPk($pk) {
        return (object) $this->selectQuery($this, "$this->pk = ?", [$pk])->fetch();
    }

    public function insert(array $parameters) {
        return $this->insertQuery($this, $parameters);
    }

    public function update(array $values) {
        return $this->updateQuery($this, $this->whereParameters, $values, $this->whereCondition)->rowCount();
    }

    public function updateByAttributes($attributes, array $values) {
        return $this->updateQuery($this, $attributes, $values, false, true)->rowCount();
    }

    public function updateByPk($pk, $values) {
        $this->whereCondition = "id = ?";
        $this->whereParameters = [$pk];
        return $this->updateQuery($this, $this->whereParameters, $values, $this->whereCondition)->rowCount();
    }
    
    public function where($condition, array $parameters = []) {
        $this->whereCondition = $condition;
        $this->whereParameters = $parameters;
        return $this;
    }

    public function setPk($pkColumn) {
        $this->pk = $pkColumn;
        return $this;
    }

    public function setRules(array $rules) {
        
    }

    public function getColumns(array $columns) {
        foreach ($columns as $column) {
            $this->selectColumns[] = "`$column`";
        }
        return $this;
    }

    public function setTable($tableName) {
        $this->table = $tableName;
        $this->selectColumns = [];
        $this->whereParameters = [];
        $this->whereCondition = false;
        return $this;
    }

}
