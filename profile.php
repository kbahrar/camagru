<?php
    require('control/control.php');
    session_start();
    if (!isset($_SESSION['id']) || empty($_SESSION['id']))
        header('Location: index.php');
    else
    {
        try
        {
            $display  = "none";
            $msg      = "none";
            $display1 = "none";
            $msg1     = "none";

            if (isset($_GET["action"]) && ($_GET["action"] == "modu" || $_GET["action"] == "mode" || $_GET["action"] == "modp"))
            {
                if (isset($_SESSION["token"]) && isset($_POST["token"]) && $_POST["token"] == $_SESSION["token"])
                {
                    if ($_GET["action"] == "modu")
                    {
                        if (isset($_POST["uname"]) && !is_array($_POST["uname"]) && !empty($_POST["uname"]))
                        {
                            if ($_POST["uname"] != $_SESSION["name"])
                                updateUser($_POST["uname"], $_SESSION["id"], 1);
                            else
                                throw new Exception("same username.");
                        }
                        else
                            throw new Exception("empty field username.");
                    }
                    if ($_GET["action"] == "mode")
                    {
                        if (isset($_POST["mail"]) && !is_array($_POST["mail"]) && !empty($_POST["mail"]))
                        {
                            if ($_POST["mail"] != $_SESSION["email"])
                                updateUser($_POST["mail"], $_SESSION["id"], 2);
                            else
                                throw new Exception("same E-mail.");
                        }
                        else
                            throw new Exception("empty field mail.");
                    }
                    if ($_GET["action"] == "modp")
                    {
                        if (isset($_POST["pwd"]) && !is_array($_POST["pwd"]) && !empty($_POST["pwd"]))
                            updateUser($_POST["pwd"], $_SESSION["id"], 3);
                        else
                            throw new Exception("empty field Password.");
                    }
                }
                else
                    throw new Exception("Invalide request.");
            }
            else if (isset($_GET["action"]) && ($_GET["action"] == "actnot" || $_GET["action"] == "desnot"))
            {
                if ($_GET["action"] == "desnot")
                    updateNot($_SESSION['id'], 0);
                else
                    updateNot($_SESSION['id'], 1);
            }
            else
                require('view/vprofile.php');
        }
        catch (Exception $e)
        {
            $display  = "none";
            $msg      = "none";
            $display1 = "inline";
            $msg1     = 'Erreur : ' . $e->getMessage();
            require('view/vprofile.php');
        }
    }
?>