<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mysql
 *
 * @author olaar
 */
require 'ElasticOrm/MysqlCommands.php';

class Mysql extends MysqlCommands {

    public function __construct($servername, $username, $dbName, $password) {
        parent::__construct($servername, $username, $dbName, $password);
        return $this;
    }

}


