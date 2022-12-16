<!-- On check si la personne est connectée avec les valeurs de sessions-->
<?php
    session_start();
	if (empty($_SESSION['id'])) {
        header('Location: /ProjetPhp/PhpFiles/login.php');
		exit();
	}
?>
<!DOCTYPE HTML>
    <head>
        <title>Liste des Matchs</title>
        <link rel="stylesheet" href="../CSS/style.css">
        <meta charset="utf-8">

        <style>
            table{
                margin: auto;
                border-collapse: collapse;
                text-align: center;
                table-layout: fixed;
                width: 70vw;
            }

            table td, table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            table tr:nth-child(even){background-color: #f2f2f2;}

            table tr:hover {background-color: #ddd;}

            table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: center;
                background-color: #0B0633;
                color: white;
            }
            
        </style>

    </head>
    
    <body>
        <?php $_GET['page'] = 2;
        include "Menu.php"?>
        <!-- Affichage du tableau des matchs avec le noom, le lieu, la date, un bouton voir equipe par ligne et un bouton voir resultat   -->
        <table>
            <tr>
                <th>Nom</th>
                <th>Lieu</th>
                <th>Date</th>
                <th>Equipe</th>
                <th>Resultat</th>
            </tr>
            <?php
                $server="127.0.0.1";
                $db="projectphp";
                $login="root";
                $mdp="";
                try {
                    $bdd = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
                }catch (Exception $e) {
                    die('Erreur : ' . $e->getMessage());
                }
                $reponse = $bdd->query("SELECT id, nom, date, heure, lieu FROM Rencontre");
                if ($reponse==false) {
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
    </body>
</DOCTYPE>

        