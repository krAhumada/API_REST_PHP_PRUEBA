<?php

class processPayment {

    private $archivoToken = __DIR__.'/token';

    private $endpointDynamicToken = "localhost/delfosti-prueba/dynamicTokens/generateToken";

    private $tokenStatic = "def00000332bee59c86de88f4afdcb66feeff2a59b1620f83afcb24420a6eaf239babf8d2a39782a8e31ebb1f4356af13cfca0d73060f839ddb7bfaffde0412048164d3d";

    function post($parametes){

        if(!file_exists($this->archivoToken)){

            $responseAuth = $this->auth();

            if($responseAuth->code === 200) {

                $dynamicToken = $responseAuth->data->token;

                if (!file_put_contents($this->archivoToken, $dynamicToken)){

                    echo json_encode(array(
                        "status" => "error",
                        "code" => 200,
                        "mensaje" => "Error al guardar Token",
                    ));

                    return;

                }
            }
        }

        $tokenSession = $this->getTokenSession();

        $validationToken = $this->validateToken($tokenSession);

        if(isset($validationToken["code"]) === 500){

            echo json_encode($validationToken);

            return;
        }

        if(isset($validationToken["isTokenValid"]) === false){

            echo $this->generateNewToken();
        }

        $insertAttemptsPayment = $this->insertAttemptsPayment();

        echo json_encode($insertAttemptsPayment);

        // echo json_encode(json_decode($parametes));

    }

    private function auth(){

        $headersHttp = array(
            "token: ". $this->tokenStatic,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->endpointDynamicToken);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headersHttp);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);

    }

    private function getTokenSession(){

        $pathConfig = dirname(__FILE__);

        $tokenSession = file_get_contents($pathConfig ."/token");

        return $tokenSession;
    }

    private function insertAttemptsPayment(){

        // $endpoint = 'localhost/delfosti-prueba/dynamicTokens/validateToken';
        $endpoint = 'localhost/delfosti-prueba/createTables/insertAttemptsPayment';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);

    }

    private function validateToken($tokenSession){

        // $endpoint = 'localhost/delfosti-prueba/dynamicTokens/validateToken';
        $endpoint = 'localhost/delfosti-prueba/createTables/validateToken';

        $headersHttp = array(
            "token: ". $tokenSession,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headersHttp);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);

    }

    private function generateNewToken(){

        $endpoint = 'localhost/delfosti-prueba/dynamicTokens/generateToken';

        $headersHttp = array(
            "token: ". $this->tokenStatic,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headersHttp);

        $response = curl_exec($ch);

        curl_close($ch);

        $dynamicToken = json_decode($response);

        if (!file_put_contents($this->archivoToken, $dynamicToken->data->token)){

            echo json_encode(array(
                "status" => "error",
                "code" => 200,
                "mensaje" => "Error al guardar Token",
            ));

            return;

        }

        return $response;

    }
}
