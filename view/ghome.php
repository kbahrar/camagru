<?php
    // session_start();
    $title = "HOME";
    $i = 1;
    ob_start();
    if(!empty($_SESSION["name"]))
    {
        $title = "Welcome " . $_SESSION["name"];
        $img = $_SESSION["img"];
        $name = $_SESSION["name"];
?>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item active">
            <a class="nav-link" href="gallery.php">Gallery <span class="sr-only">(current)</span></a>
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
        <a class="nav-link" href="http://localhost/index.php">Connexion</a>
        </li>
        </ul>
<?php
    }
    $nav = ob_get_clean();
    ob_start();
?>
    <div class="main">
    <div class="container bg-secondary text-white  text-center my-3 py-4 rounded-pill">
        <div class="row">
            <div class="col-sm-2">
                <input type="radio" name="filter" value="imoji" checked><img src="public/img/sup/1.png" width="50px" height="50px">
            </div>
            <div class="col-sm-2">
                <input type="radio" name="filter" value="dog"><img src="public/img/sup/2.png" width="50px" height="50px">
            </div>
            <div class="col-sm-2">
                <input type="radio" name="filter" value="pokemon"><img src="public/img/sup/3.png" width="50px" height="50px">
            </div>
            <div class="col-sm-2">
                <input type="radio" name="filter" value="loki"><img src="public/img/sup/4.png" width="50px" height="50px">
            </div>
            <div class="col-sm-2">
                <input type="radio" name="filter" value="ndader"><img src="public/img/sup/5.png" width="50px" height="50px">
            </div>
            <div class="col-sm-2">
                <input type="radio" name="filter" value="jwan"><img src="public/img/sup/6.png" width="50px" height="50px">
            </div>
        </div>
    </div>
    <form method="post" action="gallery.php?action=save">
        <div class="container bg-secondary text-white text-center my-3 py-4">
            <div class="row">
                <div class="col-sm-5">
                    <figure class="figure">
                        <video id="video" class="figure-img img-fluid image1"></video>
                        <figcaption class="figure-caption text-center text-white">Camera</figcaption>
                    </figure>
                </div>
                <div class="col-sm-5">
                    <figure class="figure">
                        <div class="parent">
                            <canvas id="canvas" class="figure-img img-fluid image1"></canvas>
                            <img id="snap" src="public/img/sup/1.png" class="figure-img img-fluid image2" width="30%" height="30%">
                        </div>
                        <figcaption class="figure-caption text-center text-white">Your image</figcaption>
                    </figure>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <input id="startbutton" type="button" class="btn btn-primary" value="Take a picture !">
                    <input id="img-src" type="hidden" name="image" class="image-tag">
                    <input id="filter-src" type="hidden" name="num-fil" class="filter-tag">
                </div>
                <div class="col-sm-5">
                    <input class="btn btn-success" type="submit" value="save">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5 mt-2">
                    ou
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5 mt-2">
                    <!-- <div class="input-group mb-3"> -->
                        <input type="file" id="real-file" hidden="hidden">
                        <button type="button" id="custom-button" class="btn btn-primary">CHOOSE AN IMAGE</button>
                        <span id="custom-text">No file chosen, yet</span>
                        <!-- <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inPic" aria-describedby="inputGroupFileAddon01" accept="image/*">
                            <label class="custom-file-label" for="inputGroupFile01">Choose Image</label>
                        </div> -->
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </form>
</div>
    <div class="right mb-5">
    <h2 class="text-white text-center">Your Pics</h2>
<?php
    while ($data = $posts->fetch())
    {
?>
        <div class="card text-center mt-1 ">
            <div class="card-header">
                <div class="text-right text-muted">(<?= $data['created_at'] ?>)</div>
            </div>
            <div class="card-body">
                <img src="<?= $data['img'] ?>" class=" img-thumbnail">
            </div>
            <div class="card-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <a class="btn btn-danger" href="gallery.php?action=del&post_id=<?= $data["id"]?>&user_id=<?= $data["user_id"] ?>">X</a>
                        </div>
                        <div class="col-sm">
                            <a class="btn btn-primary" href="gallery.php?action=pdp&post_id=<?= $data["id"]?>&user_id=<?= $data["user_id"] ?>">pdp</a>
                        </div>
                    </div>
                </div>
            </div>
          </div>
<?php
    }
?>
    </div>
<?php
    $content = ob_get_clean();
    require("template2.php");
?>