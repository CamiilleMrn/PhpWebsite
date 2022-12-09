<?php
    $server="localhost";
    $db="projectphp";
    $login="root";
    $mdp="";
    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
    }catch (Exception $e){
        die('Error : ' . $e->getMessage());
    }
?>

<!DOCTYPE HTML>
    <html lang="fr">
        <head>
            <title> Liste des joueurs </title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../CSS/style.css">
        </head>

        <body>
            <header>
                <nav class="menu">
                    <label class="logo"><img src="../ProjetPhpPhoto/LogoSite.jpg" alt="Logo du site"/></label>
                    <ul>
                        <li> <a class="active" href="PlayerList.php"> Liste des joueurs</a> </li>
                        <li> <a href="MatchList.php"> Liste des matchs</a> </li>
                        <li> <a href="StatPage.php"> Statistiques des joueurs</a> </li>
                    </ul>
                </nav>
            </header>
            <main>
                <h1 class="pageTitle"> Liste des joueurs </h1>

                <div class="addButton">
                    <button onclick="redirectModify()">Ajouter</button>
                    <script>
                        function redirectModify() {
                            location.href = "AddPlayer.php";
                        }
                    </script>
                </div>

                <div class="tablePlayer">
                    <table>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Photo</th>
                            <th>Action</th>
                        </tr>
                    <?php
                        $req = $linkpdo->query('select nom, prenom, photo from joueur');
                        if(!$req) {
                            die("Error, can't fetch player list");
                        }
                        while($data = $req->fetch()){
                            echo '<tr>';
                            echo '<td>'.$data['nom'].'</td>';
                            echo '<td>'.$data['prenom'].'</td>';
                            echo '<td>'.$data['photo'].'</td>';
                            echo '<td>'.'<a href="ModifyPlayer.php">Modifier</a>'." | "."Supprimer".'</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    ?>
                </div>
            </main>

            <footer>

            </footer>
        </body>
    </html>
