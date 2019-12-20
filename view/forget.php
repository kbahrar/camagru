<?php
    $title = "forget !!";
    ob_start();
?>
<form action="index.php?action=getmail" method="post">
    <div class="form">
            <h2 class="text-center mb-5">Forget Password</h2>
            <div class="form-group">
                <label for="user">Enter your mail to renew your password :</label>
                <input type="mail" class="form-control mb-5" name="mail" id="user" placeholder="Enter your mail">
            </div>
            <input type="submit" value="OK " class="btn btn-primary mb-5" class="button">
            <a href="index.php">Return !</a>
    </div>
</form>
<?php
    $content = ob_get_clean();
    require("template.php");
?>