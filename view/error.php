<?php
    $title = "login !!";
    if (!isset($erreur) || empty($erreur))
        $erreur = "404 Page not found";
    ob_start();
?>
    <div class="form">
        <h2><?= $erreur;?></h2>
        <h3><a href="index.php">Return !</a></h3>
    </div>
<?php
    $content = ob_get_clean();
    require("template.php");
?>