<?php
    require_once "autoload.php";
    require_once "session.php";

    $convid = $_SERVER["QUERY_STRING"];

    $msgDAO = new MessageDAO;
    $fDAO = new FriendshipDAO;
    $cDAO = new ConversationDAO;

    $conv = $cDAO->get($convid);
    $f = $fDAO->get($conv->getFriendshipId());
    if($_SESSION["userID"] !== $f->getFriend2()->getId() &&
        $_SESSION["userID"] !== $f->getFriend1()->getId()){
        header("Location: conversation-list.php");
        exit();
    }
    $rec = ($f->getFriend1()->getId() === $_SESSION["userID"]) ?
        $f->getFriend2()->getId(): $f->getFriend1()->getId();
    $list = $msgDAO->getAllBefore(time(), $convid);    

    require_once "head.phtml";
    require_once "mainView.phtml";
    require_once "foot.phtml";