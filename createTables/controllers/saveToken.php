<?php

require_once("connection/databaseConnection.php");

class saveToken {

    function post($parametersBody){

        $connection = new databaseConnection;

        $connection->saveToken($parametersBody);
    }
}