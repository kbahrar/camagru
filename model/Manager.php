<?php
    require('config/config.php');
    class Manager
    {
        protected function dbConnect()
        {
            try
            {
                $db = new PDO(DB_DSN, DB_USER, DB_PASS);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $db;
            }
            catch(Exception $e)
            {
                die('Erreur : '.$e->getMessage());
            }
        }

        protected function mailIt($subject, $mail, $url)
        {
            $mail = new Mailer($subject, $mail, $url);
            $s = $mail->send();
            if ($s == -1)
                throw new Exception("Mail didn't send");
            return 1;
        }
    }