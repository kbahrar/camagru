<?php
    // session_start();
    $title = "HOME";
    ob_start();
    if(!empty($_SESSION["name"]))
    {
        $title = "Welcome " . $_SESSION["name"];
        $img = $_SESSION["img"];
        $name = $_SESSION["name"];
?>
             <li class="nav-item active">
                <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="gallery.php">Gallery</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="home.php?action=decon">Deconnexion</a>
            </li>
            </ul>
            <a class="navbar-brand" href="profile.php">
                <img src="<?= $img; ?>" width="50" height="50" class="img_prf">
                <?= htmlspecialchars($name); ?>
            </a>
<?php
    }
    else
    {
?>
        <li class="nav-item">
        <a class="nav-link" href="index.php">Connexion</a>
        </li>
        </ul>
<?php
    }
    $nav = ob_get_clean();
    ob_start();
    // get informations and write this on html
?>
    <div class="mb-5">
<?php
    while ($data = $posts->fetch())
    {
?>  <a href="post.php?post_id=<?= $data['id'] ?>">
        <div class="card text-center mt-3 mx-5">
            <div class="card-header">
                <img src="../<?= $data["pdp"] ?>" width="50" height="50" class="img_prf">
                <em><b><?= htmlspecialchars($data['uname']) ?></b><em>
                <div class="text-right text-muted">(<?= $data['created_at'] ?>)</div>
            </div>
            <div class="card-body">
                <img src="<?= $data['img'] ?>" class=" img-thumbnail">
            </div>
            <div class="card-footer">
                <div class="container">
                    <div class="row">
                      <div class="col-sm px-2">
                        Likes (<?= $data['likeCount'] ?>)
                      </div>
                      <div class="col-sm px-2">
                        Comments (<?= $data['cmntCount'] ?>)
                      </div>
                    </div>
                </div>
            </div>
          </div>
    </a>
<?php
    }
?>
    <div id="result"></div>
    </div>
    <script src="public/js/main.js"></script>
<?php
    $content = ob_get_clean();
    require("template2.php");
?>