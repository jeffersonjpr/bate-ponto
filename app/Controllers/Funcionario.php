<?php

namespace App\Controllers;

use App\Models\Db;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Funcionario
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

    static function getAll(Response $response)
    {
        $sql = "SELECT * FROM funcionario";

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

    static function getById(Response $response, $id)
    {
        $sql = "SELECT * FROM funcionario WHERE id = :id";

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $customer = $stmt->fetch(\PDO::FETCH_OBJ);
            $db = null;

            $response->getBody()->write(json_encode($customer));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\PDOException $e) {
            return self::returnError($response, $e->getMessage());
        }
    }

    static function create (Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $sql = "INSERT INTO funcionario (nome, registro) VALUES (:nome, :registro)";

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $data['nome']);
            $stmt->bindParam(':registro', $data['registro']);
            $result = $stmt->execute();
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

    static function getByRegistro($registro){
        $sql = "SELECT * FROM funcionario WHERE registro = :registro";

        $registro = (int) $registro;

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':registro', $registro);
            $stmt->execute();
            $customer = $stmt->fetch(\PDO::FETCH_OBJ);
            $db = null;

            return $customer;
        } catch (\PDOException $e) {
            return null;
        }
    }

    static function update (Request $request, Response $response, $id)
    {
        $data = $request->getParsedBody();

        $sql = "UPDATE funcionario SET nome = :nome, registro = :registro WHERE id = :id";

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $data['nome']);
            $stmt->bindParam(':registro', $data['registro']);
            $result = $stmt->execute();
            $db = null;

            $response->getBody()-> write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\PDOException $e) {
            return self::returnError($response, $e->getMessage());
        }
    }

    static function delete(Response $response, $id)
    {
        $sql = "DELETE FROM funcionario WHERE id = :id";

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $result = $stmt->execute();
            $db = null;

            $response->getBody()->write(json_encode(array("message" => "Funcionario excluído com sucesso")));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\PDOException $e) {
            return self::returnError($response, $e->getMessage());
        }
    }
}