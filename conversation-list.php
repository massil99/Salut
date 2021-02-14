<?php
    require_once "autoload.php";
    require_once "session.php";

    $userid = $_SESSION["userID"];
    $conversationdao = new ConversationDAO;
    $convos = $conversationdao->getAllRelatedToUser($userid);

    require_once "head.phtml";
    require_once "header-bar.phtml";
    require_once "conversation-list.phtml";
    require_once "foot.phtml";