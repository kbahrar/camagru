<?php

require_once 'database.php';

class Setup {
	private $db;

	public function __construct() {
        try
        {
            $this->db = new PDO('mysql:host='.DB_HOST, DB_USER, DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->execute2();
        }
        catch(PDOException $e)
        {
            die('Erreur : '.$e->getMessage());
        }
	}

	public function execute2() {
        $this->createDb();
		$this->createUsers();
		$this->createPosts();
		$this->createComments();
		$this->createLikes();
	}

    public function createDb(){
        $sql = 'CREATE DATABASE IF NOT EXISTS `camagru`';
		$req = $this->db->query($sql);
		$req->execute();
    }

    public function createUsers() {
		$sql = 'CREATE TABLE IF NOT EXISTS `camagru`.`users` ( ';
		$sql .= '`id` INT NOT NULL AUTO_INCREMENT, ';
		$sql .= '`uname` VARCHAR(255) NOT NULL, ';
		$sql .= '`email` VARCHAR(255) NOT NULL, ';
		$sql .= '`pwd` VARCHAR(255) NOT NULL,';
		$sql .= '`img` VARCHAR(255) NOT NULL DEFAULT "public/img/profile-default.jpg",';
		$sql .= '`number` VARCHAR(255),';
		$sql .= '`notif` BOOLEAN NOT NULL DEFAULT TRUE,';
		$sql .= '`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,';
		$sql .= '`verify` tinyint(1) NOT NULL DEFAULT 0,';
		$sql .= '`vkey` VARCHAR(255) NOT NULL,';
		$sql .= 'PRIMARY KEY (`id`))';
		$req = $this->db->query($sql);
		$req->execute();
	}

	public function createPosts() {
		$sql = 'CREATE TABLE IF NOT EXISTS `camagru`.`posts` ( ';
		$sql .= '`id` INT NOT NULL AUTO_INCREMENT, ';
		$sql .= '`user_id` INT NOT NULL, ';
		$sql .= '`img` VARCHAR(255) NOT NULL, ';
		$sql .= '`likeCount` INT NOT NULL DEFAULT 0 , ';
		$sql .= '`cmntCount` INT NOT NULL DEFAULT 0 , ';
		$sql .= '`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, ';
		$sql .= 'PRIMARY KEY (`id`))';
		$req = $this->db->query($sql);
		$req->execute();
	}

	public function createLikes() {
		$sql = 'CREATE TABLE IF NOT EXISTS `camagru`.`likes` ( ';
		$sql .= '`id` INT NOT NULL AUTO_INCREMENT , ';
		$sql .= '`user_id` INT NOT NULL , ';
		$sql .= '`post_id` INT NOT NULL , ';
		$sql .= '`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, ';
		$sql .= 'PRIMARY KEY (`id`))';
		$req = $this->db->query($sql);
		$req->execute();
	}

	public function createComments() {
		$sql = 'CREATE TABLE IF NOT EXISTS `camagru`.`comments` ( ';
		$sql .= '`id` INT NOT NULL AUTO_INCREMENT , ';
		$sql .= '`user_id` INT NOT NULL , ';
		$sql .= '`post_id` INT NOT NULL , ';
		$sql .= '`body` TEXT NOT NULL , ';
		$sql .= '`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, ';
        $sql .= 'PRIMARY KEY (`id`))';
        $req = $this->db->query($sql);
		$req->execute();
	}
}
?>