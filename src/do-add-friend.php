<?php
    require_once "autoload.php";
    require_once "session.php";

    if(!$_SERVER["QUERY_STRING"]){
        header("Location: doSearchFriends.php");
        exit();
    }

    $data['friend1id'] = $_SESSION['userID'];
    $data['friend2id'] = $_SERVER["QUERY_STRING"];

    $f = new Friendship($data);

    $fDAO = new FriendshipDAO;
    $fDAO->insert($f);

    header("Location: conversation-list.php");
    exit();