<?php

/**
 * Description of DbCommand
 *
 * @author olaar
 */
interface DbCommands {

    /**
     * get a single row from the db
     * @$condition: optional condition to pass to where statement
     */
    public function find();

    public function findAll();

    public function findByAttributes($attributes);

    public function findByPk($pk);

    public function insert(array $parameters);

    public function delete();

    public function deleteByAttributes(array $attributes);

    public function deleteByPk($pk);

    public function update(array $values);

    public function updateByAttributes($attributes, array $parameters);

    public function updateByPk($pk, $values);
}
