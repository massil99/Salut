<?php
    require_once "autoload.php";

    if(!isset($_POST["create"])){
        header("Location: user-sign-up.php");
        exit();
    }

    if($_POST["password"] !== $_POST["passwordx"]){
        header("Location: user-sign-up.php?wrong_password");
        exit();    
    }

    $user = new User($_POST);
    $userdao = new UserDAO;
    if(($user = $userdao->insert($user)) !== null){
        session_start();
        $_SESSION["last"] = time();
        $_SESSION["userID"] = $user->getId();
    }else{
        header("Location: user-sign-up.php?registration_failed");
        exit();
    }

    header("Location: conversation-list.php ");
    exit();