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
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        </head>

        <body>
            <header>
                <nav class = "menu">
                    <input type="checkbox" id="check">
                    <label for="check" class="checkBtn">
                        <i class="fas fa-bars" ></i>
                    </label>
                    <label class = "logo"><img src="../ProjetPhpPhoto/LogoSite.jpg" alt="Logo du site"/></label>
                    <ul>
                        <li> <a href="PlayerList.php"> Liste des joueurs</a> </li>
                        <li> <a class ="active" href="MatchList.php"> Liste des matchs</a> </li>
                        <li> <a href="StatPage.php"> Statistiques des joueurs</a> </li>
                    </ul>
                </nav>
            </header>
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

