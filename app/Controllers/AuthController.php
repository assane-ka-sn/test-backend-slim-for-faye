<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use \App\Controller;

use \App\Models\AuthModel;


class AuthController extends Controller {

    public function login(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);

        $userModel = new AuthModel($this->db);
        $reponse = $userModel->login($params->login, $params->pwd);
        return $response->withJson($reponse);
    }

    public function logout(Request $request, Response $response, $args){
  		header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $userModel = new AuthModel($this->db);
        $reponse = $userModel->logout($params->token);
        return $response->withJson($reponse);
    }


}