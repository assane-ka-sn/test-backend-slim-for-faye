<?php

namespace App\Models;



class UploadModel {
	private $_db = null;

	public function __construct($db){
		$this->_db = $db;
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

    public function getMessageByGenerateName($generate_name){
        $q = $this->_db->prepare('SELECT m.* FROM messagesroom m WHERE m.generate_name=:generate_name');
        $q->execute(array(':generate_name' => $generate_name));
        $message = $q->fetch();
        return $message;
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