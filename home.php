<?php
    require('control/control.php');
    require('control/control_post.php');
    session_start();
    if (isset($_GET["action"]) && ($_GET["action"] == "decon"))
    {
        decon();
    }
    else if (isset($_GET["action"]) && $_GET["action"] == "getdata")
    {
        if (isset($_POST["start"]))
            getdata($_POST["start"], 2);
    }
    else
    {
        listPosts(0, 5);
    }