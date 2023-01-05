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

    # Recuparation des données pour le graphique et le tableau de stat
    #Par joueur, on récupère le nom, le prenom, le poste préféré, le nombre de selection en titulaire, le nomnre de selection totale, la moyenne d'évaluation par postes joué, % de match gagné
    $req = $bdd->prepare("Select joueur.id, nom, prenom,poste, postePrefere,sum(estTitulaire) nbTitulaire , count(idRencontre) nbMatch, avg(Performance) perf from joueur, participer where joueur.id = participer.idJoueur group by idJoueur, poste order by joueur.id asc, poste asc");
    $req->execute();

    $matchGagne = $bdd->prepare("Select joueur.id, count(idRencontre) nbMatchGagne from joueur,participer, rencontre where joueur.id = participer.idJoueur and participer.idRencontre = rencontre.id and victoire = 1 group by joueur.id, poste order by joueur.id asc, poste asc");
    $matchGagne->execute();

    $matchGagneTotal = $bdd->prepare("Select count(id) from rencontre where victoire = 1");
    $matchGagneTotal->execute();
    $matchGagneTotalFetch = $matchGagneTotal->fetchColumn();

    $matchPerdusTotal = $bdd->prepare("Select count(id) from rencontre where victoire = 0");
    $matchPerdusTotal->execute();
    $matchPerdus = $matchPerdusTotal->fetchColumn();


    #Fonction qui tant que l'id de joueur est le meme que le joueur précédent, on ajoute le poste joué dans un tableau
    function getPoste($donnees, $id) {
        $i = 0;
        $previousId=1;
        echo "<table class='innerTable'>";
        while ($i < count($donnees)) {
            if ($donnees[$i]['id'] == $id) {
                echo "<tr>";
                echo "<td>" .$donnees[$i]['poste'] . "</td>";
                echo "</tr>";
            }
            $i++;
        }
        echo "</table>";
    }

    function getTitulaire($donnees, $id) {
        $i = 0;
        $previousId=1;
        echo "<table class='innerTable'>";
        while ($i < count($donnees)) {
            if ($donnees[$i]['id'] == $id) {
                echo "<tr>";
                echo "<td>" .$donnees[$i]['nbTitulaire'] . "</td>";
                echo "</tr>";
            }
            $i++;
        }
        echo "</table>";
    }

    function getMoyennePerf($donnees, $id) {
        $i = 0;
        $previousId=1;
        echo "<table class='innerTable'>";
        while ($i < count($donnees)) {
            if ($donnees[$i]['id'] == $id) {
                echo "<tr>";
                echo "<td>" .$donnees[$i]['perf'] . "</td>";
                echo "</tr>";
            }
            $i++;
        }
        echo "</table>";
    }

    function getMatchGagne($donnees, $id, $donneesGen) {
        $i = 0;
        $previousId=1;
        echo "<table class='innerTable'>";
        while ($i < count($donnees)) {
            if ($donneesGen[$i]['id'] == $id) {
                echo "<tr>";
                $pourcentageMatchGagne = $donnees[$i]['nbMatchGagne'] / $donneesGen[$i]['nbMatch'] * 100;
                echo "<td>" .$pourcentageMatchGagne . "</td>";
                echo "</tr>";
            }
            $i++;
        }
        echo "</table>";
    }



?>

<!DOCTYPE HTML>
    <html lang="fr">
        <head>
            <title> Liste des joueurs </title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="../CSS/style.css">
            <style>
                .innerTable {
                    border: none;
                    width: 100%;
                }

                .innerTable td {
                    border: none;
                    padding:0;
                }

                
            </style>
        </head>

        <body>
            <?php $_GET['page'] = 3;
            include "Menu.php"
            ?>
            <main class="mainStatPage">
                <h1> Statistisques des joueurs </h1>
                <div class="left">
                    <script src=""></script>
                    <div class="pie">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
                <div class="right">
                    <table>
                        <tr>
                            <th>Joueur</th>
                            <th>Poste préféré</th>
                            <th>Poste joué</th>
                            <th>Nombre de fois titulaire</th>
                            <th>Moyenne d'évaluation</th>
                            <th>% de match gagné</th>
                            <th>Nombre de match</th>
                        </tr>
                        <?php
                            $i = 0;
                            $donnees = $req->fetchall();
                            $donneesMatchGagne = $matchGagne->fetchall();
                            $i=0;
                            while ($i < count($donnees)) {
                                echo "<tr>";
                                echo "<td>" . $donnees[$i]['nom'] . " " . $donnees[$i]['prenom'] . "</td>";
                                echo "<td>" . $donnees[$i]['postePrefere'] . "</td>";
                                echo "<td class>" ; getPoste($donnees, $donnees[$i]['id']); echo "</td>";
                                echo "<td>" ; getTitulaire($donnees, $donnees[$i]['id']); echo "</td>";
                                echo "<td>" ; getMoyennePerf($donnees, $donnees[$i]['id']); echo "</td>";
                                echo "<td>" ; getMatchGagne($donneesMatchGagne, $donnees[$i]['id'], $donnees) ; echo "</td>";
                                echo "<td>" . $donnees[$i]['nbMatch'] . "</td>";
                                echo "</tr>";
                                $i++;
                            }
                        ?>

                    </table>
                    <div id="myDiv" data-my-var="<?php echo $matchPerdus;?>"></div>
                    <div id="myDiv1" data-my-var1="<?php echo $matchGagneTotalFetch;?>"></div>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
                <script src="../JS/Chart.js"></script>
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
