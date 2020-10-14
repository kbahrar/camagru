<html>
    <head>
        <title><?= $title; ?></title>
        <link href="public/css/style.css" rel="stylesheet" /> 
        <link href="public/css/bootstrap.css" rel="stylesheet" />
    </head>
    <body>
        <header>

                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                        <a class="navbar-brand" href="home.php"><h1>Camagru</h1></a>
                          <ul class="navbar-nav mr-auto">
                            <?= $nav ?>
                      </nav>
        </header>
        <!-- we will wait for the content from view pages -->
        <?= $content ?>
                <!-- Footer -->
                <footer class=" text-white  foot">
                <!-- Copyright -->
                <div class="text-center py-3">© 2019 Copyright:
                <a href="https://profile.intra.42.fr/users/kbahrar" class="bg-dark">Kbahrar</a>
                </div>
                <!-- Copyright -->

                </footer>
<!-- Footer -->
    <?php
        if (isset($i) && $i === 1)
        {
         ?>
        <script src="public/js/cam.js"></script>
        <?php
        }
    ?>
    </body>
</html>