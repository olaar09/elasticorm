<?php

/**
 * Description of MysqlQueries
 *
 * @author olaar
 */
trait MysqlQueries {

    private function execStatement($byAttribute, $condition, $parameters, $executeQuery) {
        if ($byAttribute) {
            $parameters = array_values($condition);
            $keys = array_keys($condition);

            return $executeQuery(sprintf("%s %s", implode(" = ? AND ", $keys), " = ?"), $parameters);
        } else {
            return $executeQuery($condition, $parameters);
        }
    }

    private function selectQuery($instance, $condition = false, array $parameters = [], $byAttribute = false) {
        $executeQuery = function ($condition, $parameters) use($instance) {
            $sql = sprintf("SELECT %s FROM %s %s", (is_array($instance->selectColumns) && count($instance->selectColumns) > 0) ? implode(", ", $instance->selectColumns) : "*", $instance->table, ($condition) ? "WHERE " . $condition : "");

            // test echo $sql;
            $stmt = $instance->connection->prepare($sql);

            $stmt->execute($parameters);

            $instance->selectColumns = [];

            return $stmt;
        };

        return $instance->execStatement($byAttribute, $condition, $parameters, $executeQuery);
    }

    private function deleteQuery($instance, $condition = false, array $parameters = [], $byAttribute = false) {
        $executeQuery = function($condition, $parameters) use($instance) {
            $sql = sprintf("DELETE  FROM %s %s", $instance->table, ($condition) ? "WHERE " . $condition : "");

            $stmt = $instance->connection->prepare($sql);

            $stmt->execute($parameters);

            return $stmt;
        };

        return $instance->execStatement($byAttribute, $condition, $parameters, $executeQuery);
    }

    public function insertQuery($instance, $parameters) {

        $parameterize = array_map(function($val) {
            return $val = "?";
        }, array_keys($parameters));

        $sql = sprintf("INSERT INTO %s (%s) VALUES(%s)", $instance->table, implode(", ", array_keys($parameters)), implode(", ", $parameterize));

        return $instance->connection->prepare($sql)->execute(array_values($parameters));
    }

    public function updateQuery($instance, $whereParameters, $values, $condition = false, $byAttribute = false) {

        $execQuery = function($whereParameters, $values, $condition = false) use($instance) {
            $sql = sprintf("UPDATE %s SET %s %s", $instance->table, sprintf("%s %s", implode(" = ?, ", array_keys($values)), " = ?"), ($condition) ? " WHERE " . $condition : "");

            echo $sql;
            $stmt = $instance->connection->prepare($sql);

            $stmt->execute(array_merge(array_values($values), array_values($whereParameters)));

            return $stmt;
        };

        if ($byAttribute) {

            $conditionToString = implode(" = ?", array_keys($whereParameters)) . " = ? ";

            return $execQuery($whereParameters, $values, $conditionToString);
        } else {
            return $execQuery($whereParameters, $values, $condition);
        }
    }

    //put your code here
}
