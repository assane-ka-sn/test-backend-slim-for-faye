<?php

namespace App\Models;



class UserModel {
	private $_db = null;

	public function __construct($db){
		$this->_db = $db;
	}

    public function addmembre($newuser){
        $q = $this->_db->prepare('INSERT INTO users SET login=:login, role_id=:role_id, pwd=:pwd, pseudo=:pseudo, date_inscription=NOW()');
        $q->execute(array(':login' => $newuser->login, ':role_id' => $newuser->role_id, ':pwd' => $newuser->pwd, ':pseudo' => $newuser->pseudo));
        return $this->_db->lastInsertId();
    }

}