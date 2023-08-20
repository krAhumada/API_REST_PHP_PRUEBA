<?php

class saveAttemptsPayment{

    function post(){

        $this->validateToken($tokenSession);

    }

    private function validateToken($tokenSession){

        $endpointValidateToken = "localhost/delfosti-prueba/dynamicTokens/validateToken";

        $parametersBody = array(
            "tokenSession" => $tokenSession
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpointValidateToken);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parametersBody));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;

    }
}

?>