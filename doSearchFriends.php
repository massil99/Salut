<?php
    require_once "autoload.php";
    require_once "session.php";

    if(!isset($_GET["search"])){
        header("Location: conversation-list.php");
        exit();
    }

    $fDAO = new FriendshipDAO;
    $userdao = new UserDAO;
    $friends = [];
    if(isset($_GET["username"]))
        $friends = $userdao->getLike($_GET["username"]);
    else
        $friends = $userdao->getAll();

    $alreadyfriends = $fDAO->getFriends($userdao->get($_SESSION["userID"]));
    $alreadyfriends[] = $userdao->get($_SESSION["userID"]);
    $friends = array_diff($friends, $alreadyfriends);
    require_once "head.phtml";
    require_once "header-bar.phtml";
    require_once "searchFriends.phtml";
    require_once "foot.phtml";