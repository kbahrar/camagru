<?php
    $title = "forget !!";
    $url1 = "index.php?action=getpwd&key=" . $_GET["key"];
    ob_start();
?>
<form action="<?= $url1 ?>" method="post">
    <div class="form">
            <h2 class="text-center mb-5">Forget Password</h2>
            <div class="form-group">
                <label for="user">Enter your new password :</label>
                <small class="form-text text-danger">Should > 8 chars Mix Upcase, lowercase And numbers.</small>
                <input type="password" class="form-control mb-5" name="pwd" id="user" placeholder="Enter your pwd">
            </div>
            <input type="submit" value="OK " class="btn btn-primary mb-5" class="button">
            <a href="index.php">Return !</a>
    </div>
</form>
<?php
    $content = ob_get_clean();
    require("template.php");
?>