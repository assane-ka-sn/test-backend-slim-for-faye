<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use \App\Controller;

use \App\Models\AuthModel;
use \App\Models\ChatModel;


class ChatController extends Controller {

    public function listAllUsers(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);

        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $listAllUsers = $chatModel->listAllUsers($auth['id']);
            return $response->withJson(array('errorCode' => true, 'message' => $listAllUsers));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function envoimessageroom(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $envoimessage = $chatModel->envoimessageroom($auth['id'],$params->message);
            return $response->withJson(array('errorCode' => true, 'message' => $envoimessage));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function envoifileroom(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $chatModel->envoifileroom($auth['id'],$params->message);
            $messages = $chatModel->listAllMessagesRoom();
            return $response->withJson(array('errorCode' => true, 'message' => $messages));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function listAllMessagesRoom(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $listAllMessages = $chatModel->listAllMessagesRoom();

            return $response->withJson(array('errorCode' => true, 'message' => $listAllMessages));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function listedatainitadmin(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $listAllMessagesRoom = $chatModel->listAllMessagesRoom();
            $listAllUsers = $chatModel->listAllUsers($auth['id']);
            $listRoles = $chatModel->listRoles();
            $listGroupes = $chatModel->listGroupes();
            $datas = array('users' => $listAllUsers,'messages' => $listAllMessagesRoom,'roles' => $listRoles,'groupes' => $listGroupes);

            return $response->withJson(array('errorCode' => true, 'message' => $datas));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function addmembre(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");
        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $messagecreate = $authModel->addmembre($params->newuser);
            if(!$messagecreate){
                return $response->withJson(array('errorCode' => true, 'message' => $messagecreate));
            }
            else{
                return $response->withJson(array('errorCode' => false, 'message' => "pseudo or login unavailable"));
            }
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }


        return $response->withJson(array('errorCode' => true, 'message' => $params));
    }

    public function getrole(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");
        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $role = $chatModel->getrole($params->role_id);
            $messages = $chatModel->listAllMessagesgroup($params->role_id);
            return $response->withJson(array('errorCode' => true, 'message' => array('role' => $role, 'messages' => $messages)));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function getgroupe(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");
        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $groupe = $chatModel->getgroupe($params->groupe_id);
            $messages = $chatModel->listAllMessagesgroupe($params->groupe_id);
            return $response->withJson(array('errorCode' => true, 'message' => array('groupe' => $groupe, 'messages' => $messages)));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function listAllMessagesGroupe(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");
        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $messages = $chatModel->listAllMessagesgroupe($params->groupe_id);
            return $response->withJson(array('errorCode' => true, 'message' => $messages));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function envoimessagegroupe(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $chatModel->envoimessagegroupe($auth['id'],$params->message, intval($params->groupe_id));
            $envoimessage = $chatModel->listAllMessagesgroupe(intval($params->groupe_id));
            return $response->withJson(array('errorCode' => true, 'message' => $envoimessage));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function envoifilegroupe(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $chatModel->envoifilegroupe($auth['id'],$params->message, intval($params->groupe_id));
            $envoimessage = $chatModel->listAllMessagesgroupe(intval($params->groupe_id));
            return $response->withJson(array('errorCode' => true, 'message' => $envoimessage));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function getuser(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");
        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $user = $chatModel->getuser($params->tchat_user_id);
            $messages = $chatModel->listAllMessagesuser(intval($auth['id']),$params->tchat_user_id);
            return $response->withJson(array('errorCode' => true, 'message' => array('user' => $user, 'messages' => $messages)));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function listAllMessagesUser(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");
        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $messages = $chatModel->listAllMessagesuser(intval($auth['id']),$params->tchat_user_id);
            return $response->withJson(array('errorCode' => true, 'message' => $messages));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function envoimessageuser(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $chatModel->envoimessageuser($auth['id'],$params->message, intval($params->tchat_user_id));
            $messages = $chatModel->listAllMessagesuser(intval($auth['id']),$params->tchat_user_id);
            return $response->withJson(array('errorCode' => true, 'message' => $messages));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

    public function envoifileuser(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $data = $request->getParsedBody();
        $params = json_decode($data['params']);
        $authModel = new AuthModel($this->db);
        $auth = $authModel->isUser($params->token);
        if($auth){
            $chatModel = new ChatModel($this->db);
            $chatModel->envoifileuser($auth['id'],$params->message, intval($params->tchat_user_id));
            $messages = $chatModel->listAllMessagesuser(intval($auth['id']),$params->tchat_user_id);
            return $response->withJson(array('errorCode' => true, 'message' => $messages));
        }
        else{
            return $response->withJson(array('errorCode' => false));
        }
    }

}
