<?php

namespace App\Models;



class ChatModel {
	private $_db = null;

	public function __construct($db){
		$this->_db = $db;
	}

	public function listAllUsers($id){
        $users = array();
        $q = $this->_db->prepare('SELECT u.pseudo, u.id, u.login, u.etat, u.date_connection FROM users u WHERE u.id!=:id ORDER BY u.date_connection DESC');
        $q->execute(array(':id' => $id));
        while( $user = $q->fetch() ){
            $users[] = $user;
        }
        $q->closeCursor();
        return $users;
    }

    public function listRoles(){
        $roles = array();
        $q = $this->_db->query('SELECT r.* FROM roles r ORDER BY r.nom');
        while( $role = $q->fetch() ){
            $roles[] = $role;
        }
        $q->closeCursor();
        return $roles;
    }

    public function listGroupes(){
        $groupes = array();
        $q = $this->_db->query('SELECT g.* FROM groupes g ORDER BY g.nom');
        while( $groupe = $q->fetch() ){
            $groupes[] = $groupe;
        }
        $q->closeCursor();
        return $groupes;
    }

    public function envoimessageroom($id,$message){
        $q = $this->_db->prepare('INSERT INTO messagesroom SET message=:message, format_message=:format_message, user_id=:user_id, date_envoi=NOW()');
        $q->execute(array(':message' => $message, ':format_message' => 'texte', ':user_id' => $id));
        $messages = array();
        $qq= $this->_db->query('SELECT m.*, u.pseudo, u.token FROM messagesroom m, users u WHERE m.user_id=u.id ORDER BY m.date_envoi DESC ');
        while( $message = $qq->fetch() ){
            $messages[] = $message;
        }
        $qq->closeCursor();
        return $messages;
    }

    public function envoifileroom($id,$message){
        $q = $this->_db->prepare('INSERT INTO messagesroom SET message=:message, format_message=:format_message, original_name=:original_name, generate_name=:generate_name, user_id=:user_id, date_envoi=NOW()');
        $q->execute(array(':message'=>$message->originalName, ':format_message'=>$message->formatfile, ':original_name'=>$message->originalName, ':generate_name'=>$message->generatedName, ':user_id'=>$id));
        return $this->_db->lastInsertId();
    }

    public function listAllMessagesRoom(){
        $messages = array();
        $q = $this->_db->query('SELECT m.*, u.pseudo, u.token FROM messagesroom m, users u WHERE m.user_id=u.id ORDER BY m.date_envoi DESC');
        while( $message = $q->fetch() ){
            $messages[] = $message;
        }
        $q->closeCursor();
        return $messages;
    }

    public function getrole($id){
        $q = $this->_db->prepare('SELECT r.* FROM roles r WHERE r.id=:id');
        $q->execute(array(':id' => $id));
        $role = $q->fetch();
        return $role;
    }

    public function getgroupe($id){
        $q = $this->_db->prepare('SELECT g.* FROM groupes g WHERE g.id=:id');
        $q->execute(array(':id' => $id));
        $groupe = $q->fetch();
        return $groupe;
    }

    public function listAllMessagesgroupe($groupe_id){
        $messages = array();
        $q = $this->_db->prepare('SELECT m.*, u.pseudo, u.token FROM messagesgroup m, users u WHERE m.groupe_id=:groupe_id AND m.user_id=u.id  ORDER BY m.date_envoi DESC ');
        $q->execute(array(':groupe_id' => intval($groupe_id)));
        while( $message = $q->fetch() ){
            $messages[] = $message;
        }
        $q->closeCursor();
        return $messages;
    }

    public function envoimessagegroupe($id_user,$message, $id_groupe){
        $q = $this->_db->prepare('INSERT INTO messagesgroup SET message=:message, format_message=:format_message, user_id=:user_id, groupe_id=:groupe_id, date_envoi=NOW()');
        $q->execute(array(':message' => $message, ':format_message' => 'texte', ':user_id' => $id_user, ':groupe_id' => $id_groupe));
        return $this->_db->lastInsertId();
    }

    public function envoifilegroupe($id_user, $message, $id_groupe){
        $q = $this->_db->prepare('INSERT INTO messagesgroup SET message=:message, format_message=:format_message, original_name=:original_name, generate_name=:generate_name, user_id=:user_id, groupe_id=:groupe_id, date_envoi=NOW()');
        $q->execute(array(':message'=>$message->originalName, ':format_message'=>$message->formatfile, ':original_name'=>$message->originalName, ':generate_name'=>$message->generatedName, ':user_id'=>$id_user, ':groupe_id'=>$id_groupe));
        return $this->_db->lastInsertId();
    }

    public function getuser($id){
        $q = $this->_db->prepare('SELECT u.* FROM users u WHERE u.id=:id');
        $q->execute(array(':id' => $id));
        $user = $q->fetch();
        return $user;
    }

    public function listAllMessagesuser($user_id, $tchat_user_id){
        $messages = array();
        $q = $this->_db->prepare('SELECT m.*, u.pseudo, u.token FROM messagesuser m, users u 
          WHERE (m.user_id=:user_id AND m.tchat_user_id=:tchat_user_id AND m.user_id=u.id) OR (m.user_id=:tchat_user_id AND m.tchat_user_id=:user_id AND m.user_id=u.id) 
          ORDER BY m.date_envoi DESC 
        ');
        $q->execute(array(':user_id' => $user_id, ':tchat_user_id' => $tchat_user_id));
        while( $message = $q->fetch() ){
            $messages[] = $message;
        }
        $q->closeCursor();
        return $messages;
    }

    public function envoimessageuser($user_id,$message, $tchat_user_id){
        $q = $this->_db->prepare('INSERT INTO messagesuser SET message=:message, format_message=:format_message, user_id=:user_id, tchat_user_id=:tchat_user_id, date_envoi=NOW()');
        $q->execute(array(':message' => $message, ':format_message' => 'texte', ':user_id' => $user_id, ':tchat_user_id' => $tchat_user_id));
        return $this->_db->lastInsertId();
    }

    public function envoifileuser($user_id,$message, $tchat_user_id){
        $q = $this->_db->prepare('INSERT INTO messagesuser SET message=:message, format_message=:format_message, original_name=:original_name, generate_name=:generate_name, user_id=:user_id, tchat_user_id=:tchat_user_id, date_envoi=NOW()');
        $q->execute(array(':message'=>$message->originalName, ':format_message'=>$message->formatfile, ':original_name'=>$message->originalName, ':generate_name'=>$message->generatedName, ':user_id'=>$user_id, ':tchat_user_id'=>$tchat_user_id));
        return $this->_db->lastInsertId();
    }




}