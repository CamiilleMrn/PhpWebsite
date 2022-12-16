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
            <link rel="stylesheet" href="../CSS/style.css">
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        </head>

        <body>
            <?php
            $_GET['id']=3;
            include "Menu.php"
            ?>

            <main>

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
