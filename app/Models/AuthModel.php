<?php

namespace App\Models;



class AuthModel {
	private $_db = null;

	public function __construct($db){
		$this->_db = $db;
	}

    public function isUser($token){
        $q = $this->_db->prepare('SELECT u.id FROM users u WHERE u.token=:token');
        $q->execute(array(':token' => $token));
        $customize = $q->fetch();
        return $customize;
    }

    private function getuserbyid($login, $pwd){
        $q = $this->_db->prepare('SELECT u.*, r.nom AS role FROM users u, roles r WHERE u.login=:login and u.pwd=:pwd and u.role_id=r.id');
        $q->execute(array(':login' => $login, ':pwd' => $pwd));
        $customize = $q->fetch();
        return $customize;
    }

    public function login($login, $pwd){
        $etat = $this->getuserbyid($login, $pwd);
        if($etat){
            $Allowed_Chars = 'BCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
            $salt = "";
            for($i=0; $i<=20; $i++){$salt .= $Allowed_Chars[mt_rand(0,60)];}
            $token = crypt($pwd . $login, '$2a$05$' . $salt . '$');
            $q = $this->_db->prepare('UPDATE users u SET u.token=:token, u.etat=1, date_connection=NOW() WHERE u.id=:id');
            $q->execute(array(':token' => $token, ':id' => $etat['id']));
            return array(
                "errorCode" => true,
                "message" => array("pseudo" => $etat['pseudo'], "basetoken" => $token, "etat" => $etat['etat'], "role" => $etat['role'])
            );
        }
        else {
            return array("errorCode" => false, "message" => $etat);
        }
    }

    public function isExistUser($pseudo,$login){
        $q = $this->_db->prepare('SELECT COUNT(*) FROM users WHERE pseudo=:pseudo and login=:login');
        $q->execute(array(':pseudo' => $pseudo, ':login' => $login));
        return (bool) $q->fetchColumn();
    }

    public function logout($token){
        $etat = $this->isUser($token);
        if($etat){
            $q = $this->_db->prepare('UPDATE users u SET u.token="", u.etat=0 WHERE u.id=:id');
            $q->execute(array(':id' => $etat['id']));
        }
        return $etat;

    }

}