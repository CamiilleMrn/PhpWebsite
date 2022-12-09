<?php
    /*session_start();
    if (empty($_SESSION['id'])) {
        header('Location: https://localhost/ProjetPhp/login.php');
        exit();
    }*/

?>

<!DOCTYPE HTML>
    <html lang="fr">
        <head>
            <title> Liste des joueurs </title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../CSS/style.css">
        </head>

        <body>
            <nav class = "menu">
                <label class = "logo"><img src="../ProjetPhpPhoto/LogoSite.jpg" alt="Logo du site"/></label>
                <ul>
                    <li> <a href="PlayerList.php"> Liste des joueurs</a> </li>
                    <li> <a class ="active" href="MatchList.php"> Liste des matchs</a> </li>
                    <li> <a href="StatPage.php"> Statistiques des joueurs</a> </li>
                </ul>
            </nav>
        </body>

    </html>

