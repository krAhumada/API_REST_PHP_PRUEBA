<?php

require_once("connection/databaseConnection.php");

class validateToken {

    function post($tokenSession){

        $connection = new databaseConnection;

        $connection->validateToken($tokenSession);
    }
}