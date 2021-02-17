<?php
    require_once "autoload.php";
    require_once "session.php";

    if(!isset($_POST["submit"])){
        header("Location: mainView.php");
        exit();
    }

    $data["conversationid"] = $_POST["convid"];
    $data["reciverid"] = $_POST["reciverid"];
    $data["senderid"] = $_SESSION["userID"];
    $data["timestamp"] = time();
    $data["message"] = $_POST["message"];

    $msg = new Message($data);
    $msgdao = new MessageDAO;
    if($msgdao->insert($msg)){
        header("Refresh:0; url=mainView.php?".$msg->getConversationId());
    }else{
        header("Location: mainView.php?".$msg->getConversationId());
        exit();
    }