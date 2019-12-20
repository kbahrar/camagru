<?php
    ob_start();
    $title = "Welcome " . $_SESSION["name"];
    $img = $_SESSION["img"];
    $name = $_SESSION["name"];
?>
    <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
    </li>
    <li class="nav-item">
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
    $nav = ob_get_clean();
    ob_start();
?>
    <div class="container p-5 ml-5 mt-5 bg-light rounded shadow-lg">
        <form method="post" action="profile.php?action=modu">
                <div class="form-group">
                    <label for="username">username</label>
                    <input type="text" class="form-control" id="username" name="uname" placeholder="Username" value="<?= $_SESSION["name"] ?>">
                    <input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block mt-5">Edit Username</button>
        </form>
        <form method="post" action="profile.php?action=mode">
                <div class="form-group">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" name="mail" placeholder="Email" value="<?= $_SESSION["email"] ?>">
                    <input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block mt-5">Edit Mail</button>
        </form>
        <form method="post" action="profile.php?action=modp">
                <div class="form-group">
                    <label for="inputPassword4">Password</label>
                    <input type="password" class="form-control" name="pwd" id="inputPassword4" placeholder="Password">
                    <input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block mt-5">Edit PassWord</button>
        </form>
        <div class="alert alert-success" role="alert" style="display:<?= $display ?>">
        <?= $msg ?>
        </div>
        <div class="alert alert-danger" role="alert" style="display:<?= $display1 ?>">
        <?= $msg1 ?>
        </div>
    </div>
    <div class="container p-4 ml-5 my-5 bg-light rounded shadow-lg">
        <div class="row">
            <div class="col-sm text-center">
<?php
    if ($_SESSION["notif"] == true)
    {
?>
                <a class="btn btn-danger btn-lg" href="profile.php?action=desnot">Block Notification</a>
<?php
    }
    else
    {
?>
                <a class="btn btn-success btn-lg" href="profile.php?action=actnot">Activer Notification</a>
<?php
    }
?>
            </div>
            <div class="col-sm text-center">
                <a class="btn btn-danger btn-lg" href="gallery.php?action=delAccount">Delete your account</a>
            </div>
        </div>
    </div>
<?php
    $content = ob_get_clean();
    require("template2.php");
?>