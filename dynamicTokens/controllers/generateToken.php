<?php

require_once(__DIR__."/../vendor/autoload.php");

use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\IOException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Defuse\Crypto\File;
use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

class generateToken{

    private $staticToken;

    private $expirationTimeMinutes;

    private $apiTables;

    function __construct(){

        date_default_timezone_set('America/Lima');

        $this->staticToken = "def00000332bee59c86de88f4afdcb66feeff2a59b1620f83afcb24420a6eaf239babf8d2a39782a8e31ebb1f4356af13cfca0d73060f839ddb7bfaffde0412048164d3d";

        $this->expirationTimeMinutes = 60;

        $this->apiTables = "localhost/delfosti-prueba/createTables";

    }

    function post($tokenStatic){

        $dynamicToken = $this->generateToken($tokenStatic);

        $response = $this->saveToken($dynamicToken);

        if($response->code === 200){

            echo json_encode(array(
                "status" => "success",
                "code" => 200,
                "mensaje" => "Se genero correctamente el token",
                "data" => ["token" => $dynamicToken],
            ));
        }
    }

    function generateToken($token){

        if(!$this->staticToken || $this->staticToken !== $token){

            echo json_encode(array(
                "status" => "error",
                "code" => 500,
                "mensaje" => "Error al generar el token",
            ));

            return;
        }

        $key = key::CreateNewRandomKey();

        $stringKey = $key->saveToAsciiSafeString();

        $dynamicToken = Crypto::Encrypt($this->staticToken, $key);

        //$retrievedKey = Key::loadFromAsciiSafeString($stringKey);
        // $plaintext = Crypto::Decrypt($dynamicToken, $key);

        return $dynamicToken;

    }

    function saveToken($dynamicToken){

        $created_at = date('Y-m-d H:i:s');

        $expirationTimestamp = strtotime('+'.$this->expirationTimeMinutes.' minutes', strtotime($created_at));

        $expirationDate = date('Y-m-d H:i:s', $expirationTimestamp);

        $routeSaveToken = $this->apiTables."/saveToken";

        $dataInsert = array(
            "token" => $dynamicToken,
            "expirationDate" => $expirationDate,
            "created_at" => $created_at,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $routeSaveToken);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataInsert));

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);

    }

}