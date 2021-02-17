<?php

session_start();

if (isset($_SESSION["last"]) && $_SESSION["last"] > 0 && time() - $_SESSION["last"] < 3600) {
    $_SESSION["last"] = time();
} else {
    session_destroy();
    header("Location: user-sign-in.php");
    exit();
}