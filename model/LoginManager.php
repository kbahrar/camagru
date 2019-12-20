<?php
    require_once('model/Manager.php');
    class LoginManager extends Manager
    {
        public function connexion($name, $pwd)
        {
            $hash = hash('whirlpool', $pwd);
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT * FROM users WHERE uname = ? AND pwd = ?');
            $req->execute(array($name, $hash));
            $req = $req->fetch();
            if (empty($req))
                return -1;
            else
            {
                if ($req["verify"] == false)
                    return 0;
                else
                    return $req;
            }
        }
    }