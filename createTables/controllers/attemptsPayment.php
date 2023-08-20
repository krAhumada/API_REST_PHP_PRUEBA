<?php

require_once("connection/databaseConnection.php");

class attemptsPayment {

    public function post() {

        $connection = new databaseConnection;

        $connection->createAttemptsPayment();

    }
}