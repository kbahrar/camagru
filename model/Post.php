<?php
    require_once('model/Manager.php');
    require_once('model/Mail.php');
    class Post extends Manager
    {
        private function resize_image($url, $width, $height) {
            list($width_orig, $height_orig) = getimagesize($url);
            $ratio_orig = $width_orig / $height_orig;
            $height = $width / $ratio_orig;
            $src = imagecreatefromstring(file_get_contents($url));
            $dst = imagecreatetruecolor($width, $height);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            return $dst;
        }

        private function get_mail_post($post_id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT u.email FROM users u, posts p WHERE u.id = p.user_id AND p.id = ?');
            $req->execute(array($post_id));
            $req = $req->fetch();

            return $req["email"];
        }

        private function get_img_post($post_id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT img FROM posts WHERE id = ?');
            $req->execute(array($post_id));
            $req = $req->fetch();

            return $req["img"];
        }

        private function update_post($post_id, $flag)
        {
            $db = $this->dbConnect();
            if ($flag == 1)
                $req = $db->prepare('UPDATE posts SET likeCount = (likeCount + 1) WHERE id = ?');
            else if ($flag == 2)
                $req = $db->prepare('UPDATE posts SET cmntCount = (cmntCount + 1) WHERE id = ?');
            else if ($flag == -2)
                $req = $db->prepare('UPDATE posts SET cmntCount = (cmntCount - 1) WHERE id = ?');
            else
                $req = $db->prepare('UPDATE posts SET likeCount = (likeCount - 1) WHERE id = ?');
            $check = $req->execute(array($post_id));
            return $check;
        }

        public function upPdp($post_id, $id)
        {
            $db = $this->dbConnect();
            $img = $this->get_img_post($post_id);
            if ($img == false)
                return (false);
            else
            {
                $_SESSION["img"] = $img;
                $req = $db->prepare('UPDATE users SET img = ? WHERE id = ?');
                $check = $req->execute(array($img, $id));
                return $check;
            }
        }

        public function addPost($user_id, $img)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('INSERT INTO posts(user_id, img) VALUES (?, ?)');
            $check = $req->execute(array($user_id, $img));

            return $check;
        }

        public function remPost($id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('DELETE FROM posts WHERE id = ?');
            $check = $req->execute(array($id));

            return $check;
        }
        public function addLike($user_id, $post_id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('INSERT INTO likes(user_id, post_id) VALUES (?, ?)');
            $check = $req->execute(array($user_id, $post_id));
            if ($check !== false)
            {
                if ($_SESSION["notif"] == true)
                {
                    $mail = $this->get_mail_post($post_id);
                    $this->mailIt("like_notif", $mail, URLROOT. 'post.php?post_id=' . $post_id);
                }
                $check = $this->update_post($post_id, 1);
            }

            return $check;
        }
        
        public function remLike($user_id, $post_id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('DELETE FROM likes WHERE user_id = ? AND post_id = ?');
            $check = $req->execute(array($user_id, $post_id));
            if ($check !== false)
                $check = $this->update_post($post_id, -1);

            return $check;
        }

        public function addCmnt($user_id, $post_id, $cmnt)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('INSERT INTO comments(user_id, post_id, body) VALUES (?, ?, ?)');
            $check = $req->execute(array($user_id, $post_id, $cmnt));
            if ($check !== false)
            {
                if ($_SESSION["notif"] == true)
                {
                    $mail = $this->get_mail_post($post_id);
                    $this->mailIt("comment_notif", $mail, URLROOT.'post.php?post_id=' . $post_id);
                }
                $check = $this->update_post($post_id, 2);
            }

            return $check;
        }

        public function remCmnt($id, $post_id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('DELETE FROM comments WHERE id = ? AND post_id = ?');
            $check = $req->execute(array($id, $post_id));
            if ($check !== false)
                $check = $this->update_post($post_id, -2);

            return $check;
        }

        public function getCmnts($id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT c.*, u.uname, u.img as pdp from comments c, users u WHERE u.id = c.user_id AND post_id = ?');
            $req->execute(array($id));

            return $req;
        }

        public function check_like($post_id, $user_id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT * from likes WHERE user_id = ? AND post_id = ?');
            $req->execute(array($user_id, $post_id));
            $req = $req->fetch();
            if ($req === false)
                return -1;
            else
                return 1;
        }

        public function getPosts($start, $num)
        {
            $db = $this->dbConnect();
            $req = $db->query('SELECT p.user_id, p.id, u.uname, p.img, p.created_at, p.likeCount, p.cmntCount, u.img as pdp FROM posts p, users u WHERE u.id = p.user_id ORDER BY p.created_at DESC LIMIT ' . $start . ', '. $num);

            return $req;
        }

        public function getPost($id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT p.user_id, p.id, u.uname, p.img, p.created_at, p.likeCount, p.cmntCount, u.img as pdp FROM posts p, users u WHERE u.id = p.user_id AND p.id = ?');
            $req->execute(array($id));

            return ($req);
        }

        public function postuser($id)
        {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT u.id as user_id, p.id, p.img, p.created_at FROM posts p, users u WHERE u.id = p.user_id AND u.id = ? order by p.created_at DESC');
            $req->execute(array($id));

            return ($req);
        }

        public function save_image($img, $num_fil)
        {
            $urlfil = 'public/img/sup/' . $num_fil . '.png';
            if (!file_exists('upload/'))
                mkdir("upload/", 0700);
            $folderPath = "upload/";
          
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
          
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';

            $file = $folderPath . $fileName;
            file_put_contents($file, $image_base64);
            
            $imgTmp = $this->resize_image($file, 800, 600);
            $filter = imagecreatefromstring(file_get_contents($urlfil));
    
            $sx = imagesx($filter);
            $sy = imagesy($filter);
            imagecopy($imgTmp, $filter, 400 - ($sx / 2), 300 - ($sy / 2), 0, 0, $sx, $sy);
            imagejpeg($imgTmp, $file);
            imagedestroy($imgTmp);

            return ($file);
        }
    }