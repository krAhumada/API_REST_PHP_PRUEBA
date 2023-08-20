<?php

class databaseConnection{

    private $server;
    private $user;
    private $password;
    private $database;
    private $port;

    private $connection;

    private $status_error;

    function __construct(){

        $dataConnection =  $this->getDataConnection();

        foreach($dataConnection as $key => $data):

            $this->server = $data["server"];
            $this->user = $data["user"];
            $this->password = $data["password"];
            $this->database = $data["database"];
            $this->server = $data["server"];

        endforeach;

        $this->connection = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);

        if($this->connection->connect_error){

            return json_encode("Error al conectarse a la base de datos");

        }

        date_default_timezone_set('America/Lima');

        $this->status_error = array(
            "status" => "error",
            "code" => 500,
            "message" => "Error al procesar"
        );

    }


    private function getDataConnection(){

        $pathConfig = dirname(__FILE__);

        $jsonData = file_get_contents($pathConfig ."/config");

        return json_decode($jsonData, true);
    }


    public function createAttemptsPayment(){

        $query = "CREATE TABLE ATTEMPTS_PAYMENTS(
            id int primary key auto_increment ,
            code varchar(50),
            message varchar(500),
            `result` varchar(100),
            created_at datetime,
            updated_at datetime
        ) ENGINE=InnoDB;";

        if($this->connection->query($query)){

            $this->status_error['status'] = "success";

            $this->status_error['code'] = 200;

            $this->status_error['message'] = "Se creó correctamente la tabla";

            echo json_encode($this->status_error);

        }else{
            echo json_encode($this->status_error, true);
        }
    }

    public function dynamicToken(){

        $query = "CREATE TABLE dynamic_token(
            id INT PRIMARY KEY AUTO_INCREMENT,
            token varchar(1000),
            expiration_date datetime,
            created_at datetime
        ) ENGINE=InnoDB";

        if($this->connection->query($query)){

            $this->status_error['status'] = "success";

            $this->status_error['code'] = 200;

            $this->status_error['message'] = "Se creó correctamente la tabla";

            echo json_encode($this->status_error);

        }else{

            echo json_encode($this->status_error, true);

        }
    }

    public function saveToken($parametersBody){

        if(!$parametersBody) {

            $this->status_error['message'] = "Parametros vacío";

            echo json_encode($this->status_error);
        }

        $parameters = json_decode($parametersBody);

        $token = $parameters->token;

        $expirationDate = $parameters->expirationDate;

        $created_at = $parameters->created_at;

        $query = "INSERT INTO dynamic_token (token, expiration_date, created_at) VALUES('$token', '$expirationDate', '$created_at')";

        if($this->connection->query($query)){

            $this->status_error['status'] = "success";

            $this->status_error['code'] = 200;

            $this->status_error['message'] = "Se registro correctamente";

            echo json_encode($this->status_error);

        }else{

            echo json_encode($this->status_error, true);

        }

    }

    public function validateToken($tokenSession){

        if(!$tokenSession) {

            $this->status_error['message'] = "Parametros vacío";

            echo json_encode($this->status_error);
        }

        $currentDate = date('Y-m-d H:i:s');

        $query = "SELECT count(1) AS exists_token
        FROM dynamic_token
        WHERE token = '$tokenSession'
        AND expiration_date >= '$currentDate';";

        $rows = $this->connection->query($query);

        $arrayRows = $rows->fetch_assoc();

        if(!empty($rows) && $arrayRows["exists_token"] >= 1){

            $this->status_error['status'] = "success";

            $this->status_error['code'] = 200;

            $this->status_error['message'] = "Token valido";

            $this->status_error['isTokenValid'] = true;

            echo json_encode($this->status_error);

        }else if(!empty($rows) && $arrayRows["exists_token"] <= 0){

            $this->status_error['status'] = "succes";

            $this->status_error['code'] = 200;

            $this->status_error['message'] = "Token expirado";

            $this->status_error['isTokenValid'] = false;

            echo json_encode($this->status_error);

        }else{

            echo json_encode($this->status_error, true);

        }

    }

    public function insertAttemptsPayment(){

        $created_at = date('Y-m-d H:i:s');

        $query = "INSERT INTO attempts_payments (code, message, `result`, created_at, updated_at)
        VALUES ('200', 'INTENTO DE PAGO', 'OK', '$created_at','$created_at')";

        if($this->connection->query($query)){

            $this->status_error['status'] = "success";

            $this->status_error['message'] = "Se inserto correctamente";

            echo json_encode($this->status_error);

        }else{
            echo json_encode($this->status_error, true);
        }
    }


}

// echo "estoy en la connection";

?>