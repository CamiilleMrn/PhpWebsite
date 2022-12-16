<?php
    session_start();
        if (empty($_SESSION['id'])) {
            header('Location: /ProjetPhp/PhpFiles/login.php');
            exit();
        }
?>

<!DOCTYPE HTML>
    <html lang="fr">
        <head>
            <title> Liste des joueurs </title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../CSS/style.css">
        </head>

        <body>
            <?php $_GET['page'] = 3;
            include "Menu.php"
            ?>
            <main class="mainStatPage">
                <div class="left">
                    <script src="https://www.amcharts.com/lib/4/core.js"></script>
                    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
                    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
                    <div class="pie">

                    </div>
                </div>
                <div class="right">

                </div>
            </main>

            <footer>
                <div class="footerContent">
                    <h3> Auteurs</h3>
                    <p> Florent Combet <br>
                        Camille Marion
                    </p>
                </div>
            </footer>
        </body>

    </html>
