<?php
    require('control/control_post.php');
    session_start();
    if (empty($_SESSION['id']))
        header('Location: index.php');
    else
    {
        try
        {
            if (isset($_GET["action"]) && (($_GET["action"] == "like") || ($_GET["action"] == "unlike")))
            {
                if (isset($_GET["post_id"]) && !is_array($_GET["post_id"]))
                {
                    if ($_GET["action"] == "like")
                        like($_GET["post_id"], $_SESSION['id']);
                    else
                        unlike($_GET["post_id"], $_SESSION['id']);
                }
                else
                    throw new Exception("hhhhh That's not a beautiful way to give a like !!");
            }
            else if (isset($_GET["action"]) && ($_GET["action"]) == "cmnt")
            {
                if (isset($_POST['cmnt']) && !is_array($_POST['cmnt']) && (!empty($_POST['cmnt'])))
                {
                    if (isset($_GET["post_id"]) && !is_array($_GET['post_id']) && is_numeric($_GET["post_id"]))
                        comment($_GET["post_id"], $_SESSION["id"], $_POST["cmnt"]);
                    else
                        throw new Exception("You trying to play with me or what !!");
                }
                else
                    throw new Exception("Thats not a beauty way to comment the post !!");
            }
            else if (isset($_GET["action"]) && ($_GET["action"]) == "del")
            {
                if (isset($_GET['cmnt_id']) && isset($_GET['user_id']) && isset($_GET['post_id']))
                {
                    if (is_array($_GET['cmnt_id']) || is_array($_GET['user_id']) || is_array($_GET['post_id']))
                        throw new Exception("don't give me arrays !!");
                    else if (hash('whirlpool', $_SESSION['id']) == $_GET['user_id'])
                        uncomment($_GET['cmnt_id'], $_GET['post_id']);
                    else
                        throw new Exception("You dont have the right to delete this comment !!");
                }
                else
                    throw new Exception("Are you fucking crazy get your ass out of here !!");
            }
            else if (isset($_GET['post_id']) && !is_array($_GET['post_id'])) 
            {
                listPost($_GET["post_id"], $_SESSION["id"]);
            }
            else
            {
                throw new Exception("You trying to play with me or what !!");
            }
        }
        catch (Exception $e)
        {
            $erreur = 'Erreur : ' . $e->getMessage();
            require('view/error.php');
        }
    }