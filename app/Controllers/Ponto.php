<?php

namespace App\Controllers;

use App\Models\Db;
use App\Controllers\Funcionario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Ponto
{
    private static function returnError(Response $response, $message)
    {
        $error = array(
            "message" => $message
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }


    static function create(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        var_dump($data);
        $sql = "INSERT INTO ponto (id_funcionario, data_ponto, tipo) VALUES (:id_funcionario, :data_ponto, :tipo)";
        $funcionario = Funcionario::getByRegistro($data['registro']);
        if (!$funcionario) {
            return self::returnError($response, "Funcionário não encontrado");
        }

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_funcionario', $funcionario->id);
            $data_ponto = date('Y-m-d H:i:s');
            $stmt->bindParam(':data_ponto', $data_ponto);
            $stmt->bindParam(':tipo', $data['tipo']);
            $stmt->execute();
            $data['id'] = $conn->lastInsertId();
            $db = null;

            $response->getBody()->write(json_encode($data));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(201);
        } catch (\PDOException $e) {
            return self::returnError($response, $e->getMessage());
        }
    }

    static function delete(Response $response, $id)
    {
        $sql = "DELETE FROM ponto WHERE id = :id";

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $db = null;

            $response->getBody()->write(json_encode(array("message" => "Ponto excluído com sucesso")));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\PDOException $e) {
            return self::returnError($response, $e->getMessage());
        }
    }

    static function getAll(Response $response)
    {
        $sql = "SELECT * FROM ponto";

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->query($sql);
            $customers = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $db = null;

            $response->getBody()->write(json_encode($customers));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\PDOException $e) {
            return self::returnError($response, $e->getMessage());
        }
    }
}
