<?php
    require('control/control.php');
    session_start();
    try
    {
        if (isset($_SESSION["id"]))
            header("Location: home.php");
        else if (isset($_GET["action"]) && $_GET["action"] == "reg")
            require("view/register.php");
        elseif (isset($_GET["action"]) && $_GET["action"] == "reg1")
        {
            if (empty($_POST["mail"]) || empty($_POST["pwd"]) || empty($_POST["user"]))
                throw new Exception("Fields should not be empty !");
            else
            {
                addUser($_POST["user"], $_POST["mail"], $_POST["pwd"]);
            }
        }
        elseif (isset($_GET["action"]) && $_GET["action"] == "conx")
        {
            if (empty($_POST["pwd"]) || empty($_POST["user"]))
                throw new Exception("Fields should not be empty !");
            else
            {
                sleep(1);
                conn($_POST["user"], $_POST["pwd"]);
            }
        }
        elseif (isset($_GET["action"]) && $_GET["action"] == "verify")
        {
            if (!isset($_GET["key"]) || !is_array($_GET["key"]) || empty($_GET["key"]))
                throw new Exception("Invalide validation !");
            else
            {
                $key = $_GET["key"];
                KeyChecker($key);
            }
        }
        elseif (isset($_GET["action"]) && $_GET["action"] == "forget1")
            require("view/forget.php");
        elseif (isset($_GET["action"]) && $_GET["action"] == "getmail")
        {
            if (!isset($_POST["mail"]) || !is_array($_POST["mail"]) || empty($_POST["mail"]))
                throw new Exception("Fields should not be empty !");
            else
                checkMail($_POST["mail"]);
        }
        elseif (isset($_GET["action"]) && $_GET["action"] == "forget")
        {
            if (empty($_GET["key"]))
                throw new Exception("Invalide validation !");
            else
            {
                $key = $_GET["key"];
                KeyChecker2($key);
            }
        }
        elseif (isset($_GET["action"]) && $_GET["action"] == "getpwd")
        {
            if (empty($_GET["key"]))
                throw new Exception("Invalide validation !");
            else
            {
                $key = $_GET["key"];
                $pwd = $_POST["pwd"];
                renewPwd($key, $pwd);
            }
        }
        else
            require("view/login.php");
    }
    catch (Exception $e)
    {
        $erreur = 'Erreur : ' . $e->getMessage();
        require('view/error.php');
    }