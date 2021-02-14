<?php
    require_once "autoload.php";

    if(!isset($_POST["connect"])){
        header("Location: user-sign-in.php");
        exit();
    }

    $userdao = new UserDAO;

    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    if(($user = $userdao->connect($username, $password))!==null){
        session_start();
        $_SESSION["last"] = time();
        $_SESSION["userID"] = $user->getId();
    }else{
        header("Location: user-sign-in.php?wrong_credentials");
        exit();
    }
    header("Location: conversation-list.php");