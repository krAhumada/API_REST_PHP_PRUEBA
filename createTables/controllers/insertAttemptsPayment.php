<?php

require_once("connection/databaseConnection.php");

class insertAttemptsPayment {

    function post(){

        $connection = new databaseConnection;

        $connection->insertAttemptsPayment();
    }
}