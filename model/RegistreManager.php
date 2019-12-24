<?php
    require_once('model/Manager.php');
    require_once('model/Mail.php');
    class RegistreManager extends Manager
    {
        private function checkUser($value)
        {
            $db = $this->dbConnect();
            $check = $db->prepare('SELECT uname FROM users WHERE uname = ? OR email = ?');
            $check->execute(array($value, $value));
            $check = $check->fetch();
            if ($check === false)
                return 1;
            else
                return -1;
        }
        public function validatePwd($pwd)
        {
            $i = 0;
            $u = 0;
            $l = 0;
            $n = 0;

            while ($pwd[$i])
            {
                if (ctype_upper($pwd[$i]))
                    $u++;
                if (ctype_lower($pwd[$i]))
                    $l++;
                if (ctype_digit($pwd[$i]))
                    $n++;
                $i++;
                if (!isset($pwd[$i]))
                    break ;
            }
            if($i < 8 || $u == 0 || $n == 0 || $l == 0)
                return false;
            else
                return true;
        }

        private function retVkey($id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT vkey FROM users WHERE id = ?');
            $req->execute(array($id));
            $req = $req->fetch();

            return $req["vkey"];
        }

        public function modNot($id, $flag)
        {
            $db = $this->dbConnect();
            if ($flag == 0)
                $update = $db->prepare('UPDATE users SET verify = false WHERE id = ?');
            else
                $update = $db->prepare('UPDATE users SET verify = true WHERE id = ?');
            $check = $update->execute(array($id));

            return $check;
        }

        public function ifexestmail($mail)
        {
            $db = $this->dbConnect();

            $req = $db->prepare('SELECT * from users WHERE email = ?');
            $req->execute(array($mail));
            $req = $req->fetch();
            if ($req == true)
                return true;
            return false;
        }

        public function validateEMAIL($mail)
        {
            $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
 
            if (preg_match($pattern, $mail) === 1) {
                if ($this->ifexestmail($mail) == false)
                    return true;
            }
            return false;
        }

        public function retUser($name, $mail, $pwd)
        {
            $hash = hash('whirlpool', $pwd);
            $db = $this->dbConnect();
            $check = $db->prepare('SELECT uname FROM users WHERE uname = ?');
            $check->execute(array($name));
            $check = $check->fetch();
            if ($check === false)
            {
                $vkey = md5(time());
                $req = $db->prepare('INSERT INTO users(uname, email, pwd, verify, vkey) Values (?, ?, ?, false, ?)');
                $check = $req->execute(array($name, $mail, $hash, $vkey));
                if ($check !== false)
                    $this->mailIt("mail_confirm", $mail, URLROOT.'index.php?action=verify&key=' . $vkey);
    
                return $check;
            }
            else
                return -1;
        }

        public function getUser($mail)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT * FROM users WHERE email = ?');
            $req->execute(array($mail));
            $req = $req->fetch();
            if ($req !== false)
                $this->mailIt("pwd_reset", $mail, URLROOT. 'index.php?action=forget&key='. $req["vkey"]);
            return $req;
        }

        public function checkKey($key)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT * FROM users WHERE vkey = ?');
            $req->execute(array($key));
            $req = $req->fetch();

            if (empty($req["id"]))
                return -1;
            else
            {
                $db2 = $this->dbConnect();
                $update = $db2->prepare('UPDATE users SET verify = true WHERE id = ?');
                $id = $req["id"];
                $update->execute(array($id));
                return $id;
            }
        }

        public function updatePwd($key, $pwd)
        {
            $pwd = hash('whirlpool', $pwd);
            $db = $this->dbConnect();
            $update = $db->prepare('UPDATE users SET pwd = ? WHERE vkey = ?');
            $update->execute(array($pwd, $key));
        }

        public function updateKey($id)
        {
            $vkey = md5(time());
            $db2 = $this->dbConnect();
            $update = $db2->prepare('UPDATE users SET vkey = ? WHERE id = ?');
            $update->execute(array($vkey, $id));
        }

        public function modName($value, $id)
        {
            if ($this->checkUser($value) == -1)
                return -1;
            else
            {
                $db = $this->dbConnect();
                $update = $db->prepare('UPDATE users SET uname = ? WHERE id = ?');
                $check = $update->execute(array($value, $id));
                if ($check !== false)
                    $_SESSION["name"] = $value;
                return $check;
            }
        }

        public function modMail($value, $id)
        {
            if ($this->checkUser($value) == -1)
                return -1;
            else
            {
                $db = $this->dbConnect();
                $update = $db->prepare('UPDATE users SET email = ?, verify = false WHERE id = ?');
                $check = $update->execute(array($value, $id));
                $vkey = $this->retVkey($id);
                if ($check !== false)
                {
                    $this->mailIt("mail_confirm", $value, URLROOT . 'index.php?action=verify&key=' . $vkey);
                    $_SESSION["email"] = $value;
                }
                return $check;
            }
        }

        public function modPwd($value, $id)
        {
            $pwd = hash('whirlpool', $value);
            $db = $this->dbConnect();
            $update = $db->prepare('UPDATE users SET pwd = ? WHERE id = ?');
            $check = $update->execute(array($pwd, $id));
            return $check;
        }
    }