<?php
require_once "autoload.php";

class Message{
    private $id;
    private $message;
    private $conversationId;
    private $senderid;
    private $reciverid;
    private $timestamp;

    public function __construct($data){
        $this->id = (isset($data["id"]))? $data["id"]: null;
        $this->message = (isset($data["message"]))? $data["message"]: null;
        $this->conversationId = (isset($data["conversationid"]))? $data["conversationid"]: null;
        $this->senderid = (isset($data["senderid"]))? $data["senderid"]: null;
        $this->reciverid = (isset($data["reciverid"]))? $data["reciverid"]: null;
        $this->timestamp = (isset($data["timestamp"]))? $data["timestamp"]: time();
    }

    public function getId(){
        return $this->id;
    }

    public function getMessage(){
        return $this->message;
    }

    public function getSenderId(){
        return $this->senderid;
    }

    public function getReciverId(){
        return $this->reciverid;
    }

    public function getTimestamp(){
        return $this->timestamp;
    }

    public function getConversationId(){
        return $this->conversationId;
    }
}