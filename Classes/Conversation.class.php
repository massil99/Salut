<?php
require_once "autoload.php";

class Conversation{
    private $id;
    private $friendshipid;
    private $title;
    private $createdAt;

    public function __construct($data){
        $this->id = (isset($data["id"]))? $data["id"]: null;
        $this->title = (isset($data["title"]))? $data["title"]: null;
        $this->friendshipid = (isset($data["friendshipid"]))? $data["friendshipid"]: null;
        $this->createdAt = (isset($data["createdat"]))? $data["createdat"]: time();
    }

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getCreationDateTime(){
        return $this->createdAt;
    }

    public function getFriendshipId(){
        return $this->friendshipid;
    }
}       
