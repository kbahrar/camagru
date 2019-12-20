<?php
    $title = "login !!";
    ob_start();
?>
<form action="index.php?action=conx" method="post">
    <div class="form">
            <h2 class="text-center mb-5">Login</h2>
            <div class="form-group">
                <label for="user">UserName :</label>
                <input type="text" class="form-control mb-5" name="user" id="user" placeholder="User Name">
            </div>
            <div class="form-group">
                <label for="pwd">PassWord :</label>
                <input type="password" class="form-control mb-5" name="pwd" id="pwd" placeholder="Password">
            </div>
            <input type="submit" value="Connexion" class="btn btn-primary mb-5" class="button">
            <span class="text-danger">Ou  </span>
            <a href="index.php?action=reg">Register !</a><br>
            <a href="index.php?action=forget1">Forget password !</a>
            </div>
</form>
<?php
    $content = ob_get_clean();
    require("template.php");
?>