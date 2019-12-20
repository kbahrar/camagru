<?php
    require('model/Post.php');
    function call_addPost($user_id, $img, $num_fil)
    {
        $p = new Post();
        $img_fil = $p->save_image($img, $num_fil);
        if (empty($img_fil))
            throw new Exception("Something went wrong !!");
        $post = $p->addPost($user_id, $img_fil);
        if ($post === false)
            throw new Exception("Something went wrong !!");
        else
            header("Location: home.php");
    }

    function call_remPost($id)
    {
        $p = new Post();
        $del = $p->remPost($id);
        if ($del === false)
            throw new Exception("Something went wrong !!");
        else
            header("Location: gallery.php");
    }

    function change_pdp($post_id, $id)
    {
        $p = new Post();
        $up = $p->upPdp($post_id, $id);
        if ($up === false)
            throw new Exception("Something went wrong !!");
        else
            header("Location: gallery.php");
    }

    function like($post_id, $user_id)
    {
        $p = new Post();
        $like = $p->addLike($user_id, $post_id);
        if ($like === false)
            throw new Exception("Something went wrong !!");
        else
            header("Location: post.php?post_id=" . $post_id);
    }

    function unlike($post_id, $user_id)
    {
        $p = new Post();
        $like = $p->remLike($user_id, $post_id);
        if ($like === false)
            throw new Exception("Something went wrong !!");
        else
            header("Location: post.php?post_id=" . $post_id);
    }

    function comment($post_id, $user_id, $cmnt)
    {
        $p = new Post();
        $cmnt = $p->addCmnt($user_id, $post_id, $cmnt);
        if ($cmnt === false)
            throw new Exception("Something went wrong !!");
        else
            header("Location: post.php?post_id=" . $post_id);
    }

    function uncomment($id, $post_id)
    {
        $p = new Post();
        $like = $p->remCmnt($id, $post_id);
        if ($like === false)
            throw new Exception("Something went wrong !!");
        else
            header("Location: post.php?post_id=" . $post_id);
    }

    function listPosts($start, $num)
    {
        $p = new Post();
        $posts = $p->getPosts($start, $num);

        require('view/vhome.php');
    }

    function listPost($id, $user_id)
    {
        $p = new Post();
        $post = $p->getPost($id);
        $cmnts = $p->getCmnts($id);
        $post = $post->fetch();
        $like = $p->check_like($id, $user_id);
        if ($post === false)
            throw new Exception("Post Does not exist don't try to crash me !!");
        else
            require('view/vpost.php');
    }

    function retDiv($data)
    {
        $div = '<a href="post.php?post_id='. $data['id'] . '">
              <div class="card text-center mt-3 mx-5">
                  <div class="card-header">
                      <img src="../'. $data["pdp"] . '" width="50" height="50" class="img_prf">
                      <em><b>' . htmlspecialchars($data['uname']) . '</b><em>
                      <div class="text-right text-muted">('. $data['created_at'] . ')</div>
                  </div>
                  <div class="card-body">
                      <img src="'. $data['img'] .'" class=" img-thumbnail">
                  </div>
                  <div class="card-footer">
                      <div class="container">
                          <div class="row">
                            <div class="col-sm px-2">
                              Likes ('. $data['likeCount'] .')
                            </div>
                            <div class="col-sm px-2">
                              Comments ('.$data['cmntCount'] .')
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
            </a>';
        return $div;
    }
    
    function getdata($start, $num)
    {
        $ret = '';
        $p = new Post();
        $posts = $p->getPosts($start, $num);
        while ($data = $posts->fetch())
        {
            $ret = $ret . retDiv($data);
        }
        if (!empty($ret))
            echo $ret;
        else
            echo '';
    }

    function getpostuser($id)
    {
        $p = new Post();
        $posts = $p->postuser($id);
        require("view/ghome.php");
    }