<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" /> 
        <link href="public/css/bootstrap.css" rel="stylesheet" /> 
    </head>   
    <body>
        <header class="head">
            <h1><a href="home.php">Camagru</a></h1>
        </header>
        <!-- we will wait for the content from view pages -->
        <?= $content ?>
        <footer class="page-footer font-small blue pt-4 text-white bg-dark m-4">
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2019 Copyright:
        <a href="https://profile.intra.42.fr/users/kbahrar">Kbahrar</a>
        </div>
        <!-- Copyright -->

        </footer>
    </body>
</html>