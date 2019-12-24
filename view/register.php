<?php
    $title = "login !!";
    ob_start();
?>
<form action="index.php?action=reg1" method="post">
    <div class="form">
        <h2 class="text-center mb-5">Register !</h2>
            <div class="form-group">
                <label for="user">UserName :</label>
                <input type="text" class="form-control mb-5" name="user" id="user" placeholder="User Name">
            </div>
            <div class="form-group">
                <label for="mail">E-mail :</label>
                <input type="email" class="form-control mb-5" name="mail" id="mail" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="pwd">PassWord :</label>
                <small class="form-text text-danger">Should > 8 chars Mix Upcase, lowercase And numbers.</small>
                <input type="password" class="form-control mb-5" name="pwd" id="pwd" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="submit" value="Registre" class="btn btn-primary mb-5">
                <span class="text-danger">Ou  </span>
                <a href="index.php">Login !</a>
            </div>
        </div>
    </div>
</form>
<?php
    $content = ob_get_clean();
    require("template.php");
?>