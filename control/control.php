<?php
    require('model/RegistreManager.php');
    require('model/LoginManager.php');

    function addUser($name, $mail, $pwd)
    {
        $rm = new RegistreManager();
        if ($rm->validateEMAIL($mail) == false)
            throw new Exception("mail exist, or not valid !");
        else if ($rm->validatePwd($pwd) == false)
            throw new Exception("Password too easy !");
        else
        {
            $user = $rm->retUser($name, $mail, $pwd);
            if ($user === false)
                throw new Exception("registre not valid !");
            else if ($user === -1)
                throw new Exception("UserName exist Choose another !");
            else
            {
                $erreur = 'Warning : Your compte wait for you !!<br>Go to your mail and validate it';
                require('view/error.php');
            }
        }
    }

    function updateUser($value, $id, $flag)
    {
        $rm = new RegistreManager();

        if ($flag == 3 && $rm->validatePwd($value) == false)
            throw new Exception("Password too easy !");
        else if ($flag == 2 && $rm->validateEMAIL($value) == false)
            throw new Exception("Mail not valid !");
        else
        {
            if ($flag == 1)
                $req = $rm->modName($value, $id);
            else if ($flag == 2)
                $req = $rm->modMail($value, $id);
            else
                $req = $rm->modPwd($value, $id);
            
            if ($req === false)
                throw new Exception("something went wrong !");
            else if ($req === -1)
                throw new Exception("UserName or mail exist Choose another !");
            else
            {
                $display  = "inline";
                $msg      = "Updated with succes !!";
                $display1 = "none";
                $msg1     = "none";
                require('view/vprofile.php');
            }
        }
    }

    function updateNot($id, $flag)
    {
        $rm = new RegistreManager();

        $req = $rm->modNot($id, $flag);
        if ($req == false)
            throw new Exception("something went wrong !");
        else
        {
            $_SESSION["notif"] = $flag;
            $display  = "inline";
            $msg      = "Updated with succes !!";
            $display1 = "none";
            $msg1     = "none";
            require('view/vprofile.php');
        }
    }

    function conn($name, $pwd)
    {
        $lg = new LoginManager();
        $ret = $lg->connexion($name, $pwd);
        if ($ret === -1)
            throw new Exception("Password ou username Incorecct !");
        elseif ($ret === 0)
            throw new Exception("You should confirm your compte par email!");
        else
        {
            $_SESSION["id"] = $ret["id"];
            $_SESSION["name"] = $ret["uname"];
            $_SESSION["img"] = $ret["img"];
            $_SESSION["email"] = $ret["email"];
            $_SESSION["notif"] = $ret["notif"];
            $_SESSION["token"] = bin2hex(random_bytes(10));
            header('Location: home.php');
        }
    }

    function decon()
    {
        session_destroy();
        header("Location: index.php");
    }
    
    function KeyChecker($key)
    {
        $rm = new RegistreManager();
        $check = $rm->checkKey($key);
        if ($check == -1)
            throw new Exception("invalid key !");
        else
        {
            $rm->updateKey($check);
            $erreur = '<b>Congrats</b> : Your compte is validate with success !!<br>return and log to it';
            require('view/error.php');
        }
    }

    function checkMail($mail)
    {
        $lg = new RegistreManager();
        $req = $lg->getUser($mail);
        if ($req === false)
            throw new Exception("email non enregistrer dans base de donnees !!");
        else
        {
            $erreur = 'Warning : Your compte wait for you !!<br>Go to your mail and get the url for renew your pwd';
            require('view/error.php');
        }
    }

    function KeyChecker2($key)
    {
        $rm = new RegistreManager();
        $check = $rm->checkKey($key);
        if ($check == -1)
            throw new Exception("invalid key !");
        else
        {
            require('view/forget2.php');
        }
    }

    function renewPwd($key, $pwd)
    {
        $rm = new RegistreManager();
        $ret = $rm->updatePwd($key, $pwd);
        if ($ret == -1)
            throw new Exception("invalid key !");
        else if ($rm->validatePwd($pwd) == false)
            throw new Exception("Password too easy !");
        else
        {
            $rm->updateKey($ret);
            $erreur = 'Warning : You update your password<br>with success !!';
            require('view/error.php');
        }
    }