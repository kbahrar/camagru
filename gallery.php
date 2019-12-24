<?php
    require('control/control.php');
    require('control/control_post.php');
    try
    {
        session_start();
        if (!empty($_SESSION["name"]))
        {
            if (isset($_GET["action"]) && ($_GET["action"] == "decon"))
            {
                decon();
            }
            else if (isset($_GET["action"]) && ($_GET["action"] == "save"))
            {
                if (!isset($_POST["image"]) || is_array($_POST["image"]) || empty($_POST["image"]))
                    throw new Exception("Invalid Image !");
                else if (!isset($_POST["num-fil"]) || is_array($_POST["num-fil"]) || empty($_POST["num-fil"]) || !is_numeric($_POST["num-fil"]))
                    throw new Exception("Filter Invalid !!");
                else
                {
                   call_addPost($_SESSION["id"], $_POST["image"], $_POST["num-fil"]); 
                }
            }
            if (isset($_GET["action"]) && (($_GET["action"] == "del") || ($_GET["action"] == "pdp")))
            {
                if (isset($_GET["user_id"]) && isset($_GET["post_id"]))
                {
                    if ($_GET["user_id"] == $_SESSION["id"])
                    {
                        if ($_GET["action"] == "del")
                            call_remPost($_GET["post_id"], $_SESSION["id"]);
                        else
                            change_pdp($_GET["post_id"], $_GET["user_id"]);
                    }
                    else
                        throw new Exception("Permission denied !!");
                }
                else
                    throw new Exception("Action Invalid !!");
            }
            else
            {
                getpostuser($_SESSION["id"]);
            }
        }
        else
            header("Location: index.php");
    }
    catch (Exception $e)
    {
        $erreur = 'Error : ' . $e->getMessage();
        require('view/error.php');
    }