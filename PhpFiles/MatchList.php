<!-- On check si la personne est connectée avec les valeurs de sessions-->
<?php
    session_start();
	if (empty($_SESSION['id'])) {
        header('Location: /ProjetPhp/PhpFiles/login.php');
		exit();
	}

    $server="127.0.0.1";
    $db="projectphp";
    $login="root";
    $mdp="";
    try {
        $bdd = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
    }catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
?>
<!DOCTYPE HTML>
    <head>
        <title>Liste des Matchs</title>
        <link rel="stylesheet" href="../CSS/style.css">
        <meta charset="utf-8">

    </head>
    
    <body>
        <?php $_GET['page'] = 2;
        include "Menu.php"?>
        <main>
            <h1 class="pageTitle"> Liste des Matchs </h1>
        <!-- Affichage du tableau des matchs avec le noom, le lieu, la date, un bouton voir equipe par ligne et un bouton voir resultat   -->
            <div class="tablePlayer">
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Lieu</th>
                        <th>Date</th>
                        <th>Equipe</th>
                        <th>Resultat</th>
                    </tr>
                    <?php
                        $reponse = $bdd->query("SELECT id, nom, date, heure, lieu FROM Rencontre");
                        if (!$reponse) {
                            die('Erreur, impossible de récuperer la liste des matchs');
                        }
                        while ($donnees = $reponse->fetch())
                        {
                            $dateFormate = date("l F", strtotime($donnees['date']));
                            $heureFormate = date("H\hi", strtotime($donnees['heure']));
                            echo '<tr>';
                            echo '<td>'.$donnees['nom'].'</td>';
                            echo '<td>'.$donnees['lieu'].'</td>';
                            echo '<td>'.$dateFormate." ".$heureFormate.'</td>';
                            echo '<td><a href="listeEquipe.php?id='.$donnees['id'].'">Voir Equipe</a></td>';
                            echo '<td><a href="listeResultat.php?id='.$donnees['id'].'">Voir Resultat</a></td>';
                            echo '</tr>';
                        }
                    ?>
                </table>
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

        