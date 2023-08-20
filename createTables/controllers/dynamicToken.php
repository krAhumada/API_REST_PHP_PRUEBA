<?php

require_once("connection/databaseConnection.php");

class dynamicToken {

    public function post(){

        $connection = new databaseConnection;

        $connection->dynamicToken();
    }
}