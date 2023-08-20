<?php

class validateToken{

    function post($tokenSession){

        $endpointValidateToken = "localhost/delfosti-prueba/createTables/validateToken";

        $headersHttp = array(
            "token: ". $tokenSession,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpointValidateToken);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headersHttp);

        $response = curl_exec($ch);

        curl_close($ch);

        echo $response;

    }

}

?>