<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use \App\Controller;

use \App\Models\AuthModel;
use \App\Models\UserModel;


class UserController extends Controller {

    public function addmembre(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);

        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $etat = $authModel->isExistUser($params->newuser->pseudo,$params->newuser->login);
            if(!$etat) {
                $userModel = new UserModel($this->db);
                $messagecreate = $userModel->addmembre($params->newuser);
                return $response->withJson(array('errorCode' => true, 'message' => $messagecreate));
            }
            else{
                return $response->withJson(array('errorCode' => false, 'message' => "pseudo or login unavailable"));
            }
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

}