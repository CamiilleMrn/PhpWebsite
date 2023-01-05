<!DOCTYPE HTML>
<?php
    session_start();
	if (empty($_SESSION['id'])) {
        header('Location: /ProjetPhp/PhpFiles/login.php');
		exit();
	}

    if (!isset($_GET['id'])) {
        header('Location: /ProjetPhp/PhpFiles/MatchList.php');
    }

    $tournamentId = $_GET['id'];
    $server="localhost";
    $db="projectphp";
    $login="root";
    $mdp="";
    try {
        $bdd = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
    }catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    function checkInputScore($scoreAdv, $scoreNous) {
        #Si une equipe a plus de set que l'autre, sachant qu'un set est gagne a 21 points avec 2 points décisif d'avance sur l'adversaire
        #Si il y a 2 set à 2 sets, il faut que l'un des deux gagne le 3eme set à 15 points avec 2 points décisif d'avance sur l'adversaire

        $scoreAdv = explode("-", $scoreAdv);
        $scoreNous = explode("-", $scoreNous);
        $setGagneNous = 0;
        $setGagneAdv = 0;
        $i=0;
        $pointMax = array(25,25,25,25,15);
        while($i<count($scoreAdv)) {
            $scoreSetAdv = $scoreAdv[$i];
            $scoreSetNous = $scoreNous[$i];
            $setNumber = $i+1;
            echo "<script>console.log('set numero $setNumber, score adv $scoreSetAdv, score nous $scoreSetNous, point max $pointMax[$i]');</script>";
            

            if ($setGagneAdv >= 3 || $setGagneNous >= 3) {
                if ($scoreSetAdv != 0 || $scoreSetNous != 0) {
                    echo "<script>alert('Erreur de score : le set numero $setNumber est non joué et doit avoir un score de 0');</script>";
                    return false;
                }
            }
            if ($scoreSetAdv > $pointMax[$i] || $scoreSetNous > $pointMax[$i]) {
                if (abs($scoreSetAdv - $scoreSetNous) > 2) {
                    echo "<script>alert('Erreur de score : deux points d\'écart necessaire set numero $setNumber');</script>";
                    return false;
                }

            } else if ($scoreSetAdv == $pointMax[$i] || $scoreSetNous == $pointMax[$i])  {
                if (abs($scoreSetAdv - $scoreSetNous) < 2) {
                    echo "<script>alert('Erreur de score : set numero $setNumber : un  ecart de moins de 2 est attendu');</script>";
                    return false;
                }
            } else {
                echo "<script>alert('Erreur de score : set numero $setNumber : aucune équipe n\'a attend le score permettant de gagner le set');</script>";
                return false;
            }

            if ($scoreSetAdv > $scoreSetNous) {
                $setGagneAdv++;
            } else if ($scoreSetAdv < $scoreSetNous) {
                $setGagneNous++;
            } else {
                echo "<script>alert('Erreur de score : un meme les equipes ne peuvent avoir le meme score set numero $setNumber ');</script>";
                return false;
            }

            
            $i++;
        }
        return true;

    }

    function checkWin($scoreAdv, $scoreNous){
        $scoreAdv = explode("-", $scoreAdv);
        $scoreNous = explode("-", $scoreNous);
        $setGagnéNous = 0;
        $setGagnéAdv = 0;
        $i =0;
        while($i<count($scoreAdv)) {
            $scoreSetAdv = $scoreAdv[$i];
            $scoreSetNous = $scoreNous[$i];
            if ($scoreSetAdv > $scoreSetNous) {
                $setGagnéAdv++;
            } else {
                $setGagnéNous++;
            }
            $i++;
        }
        if($setGagnéAdv > $setGagnéNous){
            return 0;
        }
        return 1;
    }

    if (isset($_POST['submit'])) {
        $i=0;
        $scoreAdv = "";
        $scoreNotre = "";
        while($i<count($_POST['setAdv'])-1) {
            $scoreAdv = $scoreAdv.$_POST['setAdv'][$i]."-";
            $scoreNotre = $scoreNotre.$_POST['setNotre'][$i]."-";
            $i++;
        }
        $scoreAdv = $scoreAdv.$_POST['setAdv'][$i];
        $scoreNotre = $scoreNotre.$_POST['setNotre'][$i];
        if (checkInputScore($scoreAdv, $scoreNotre)) {
            /*Set value of score*/
            $win = checkWin($scoreAdv,$scoreNotre);
            echo $win;
            $query = $bdd->prepare("UPDATE Rencontre SET resultatAdversaire = :scoreAdv, resultatNotreEquipe = :scoreNotre, victoire = :win WHERE id = :id");
            $query->execute(array(
                'scoreAdv' => $scoreAdv,
                'scoreNotre' => $scoreNotre,
                'id' => $tournamentId,
                'win' => $win
            ));

            $perf = $_POST['perf'];
            $i=0;
            while($i<count($perf)) {
                $dum = $perf[$i];
                $dum2 = $_POST['idJoueur'][$i];
                $query = $bdd->prepare("update participer set Performance = :perf where idJoueur = :idJoueur and idRencontre = :idRencontre");
                $query->execute(array(
                    'perf' => $perf[$i],
                    'idJoueur' => $_POST['idJoueur'][$i],
                    'idRencontre' => $tournamentId
                ));
                $i++;
            }
            echo "<script>alert('Resultat enregistre');</script>";
        }
    }



    


?>

<html lang ="fr">
    <head>
        <title>Inserer resultat</title>
        <link rel="stylesheet" href="../CSS/style.css">
        <meta charset="utf-8">

        <style>

            /* Table sur la gauche de la page */
            #resultatMatch {
                width:40%;
                float:left;
            }

            td + td{
                text-align:left;
                padding-left:50px;
            }
            /* les deux tables sont cote a cote*/
            #resultatMatch, #resultatJoueur {
                display:inline-block;
                margin-left:50px;
            }

            /* Table sur la droite de la page */
            #resultatJoueur {
                width:50%;
                float:right;
            }

            /* Les noms d'équipes sont chahcun au dessus de leur colonne du tableau */
            table tr:first-child td {
                color:red;
                text-align:center;
                padding-left:8px;
                background-color:transparent;
                border: none;
                padding-bottom:50px;
                font-size:25px;
                font-weight:bold;
            }

            table tr:first-child:hover {
                background-color:transparent;
            }

            table tr:first-child td {
                background-color:transparent;
                border: none;
            }

            .nomEquipe:nth-child(1) {
                margin-left:250px;
            }

            #setNumber{
                width:50px;
                text-align:center;
            }

            .resultat {
                width:80%;
            }

            #score{
                width:100px;
            }

            td:nth-child(1) {
                text-align:center;
            }

            #resultatJoueur {
                margin-top:50px;
            }

            #resultatJoueur table td{
                text-align:center;
                padding-top:20px;
            }

            /* Bouton valider en bas au milieu en gros*/
            #valider {
                margin-left:45%;
                margin-top:100px;
                width:100px;
                height:50px;
                font-size:20px;
                font-weight:bold;
            }
        </style>
    </head>
    <body>
        <!-- Titre de la page en haut -->
        <?php $_GET['page'] = 2;
        include "Menu.php"?>
        <main>
            <?php 
                $query = $bdd->prepare("SELECT nom, equipeAdverse, resultatAdversaire, resultatNotreEquipe FROM Rencontre WHERE id = :id");
                $query->execute(array(
                    'id' => $tournamentId
                ));
                $result = $query->fetch();
                $nom = $result['nom'];
                $equipeAdverse = $result['equipeAdverse'];
                $resultatAdversaire = $result['resultatAdversaire'];
                $resultatNotreEquipe = $result['resultatNotreEquipe'];

            ?>
            <form action="listResult.php?id=<?=$tournamentId?>" method="post">
                <h1 class="pageTitle"> <?=$nom?> </h1>
                <div id="resultatMatch">

                
                    <table class="resultat">
                        <col id="setNumber"/>
                        <col span="2" id="score"/>
                        <tr>
                            <td></td>
                            <td><?=$equipeAdverse?></td>
                            <td>Notre equipe</td>
                        </tr>
                        <tr>
                            <th>Set</th>
                            <th>Score <?=$equipeAdverse?></th>
                            <th>Score Notre equipe</th>
                        </tr>
                        <?php
                            $i=0;
                            while ($i<5) {
                                # Les points des equipes sont sous la forme 00-00-00-00-00
                                $iAdv = substr($resultatAdversaire, $i*3, 2);
                                $iNotre = substr($resultatNotreEquipe, $i*3, 2);
                                echo '<tr>';
                                echo '<td>'.($i+1).'</td>';
                                echo '<td>'; echo "<input type=number onchange=".'if(parseInt(this.value,10)<10)this.value=\'0\'+this.value;'." name='setAdv[]' value = $iAdv step='1' min='0'>"; echo'</td>';
                                echo '<td>'; echo "<input type=number onchange=".'if(parseInt(this.value,10)<10)this.value=\'0\'+this.value;'." name='setNotre[]' value = $iNotre step='1' min='0'>"; echo'</td>';
                                echo '</tr>';
                                $i++;
                            }
                        ?>
                    </table>
                </div>

                <div id="resultatJoueur">
                    <table class="resultat">
                        <tr>
                            <th>Joueur</th>
                            <th>Evaluation</th>
                        </tr>
                        <?php
                            $query = $bdd->query("SELECT joueur.id, nom, prenom, Performance  FROM joueur, participer where joueur.id = participer.idJoueur and idRencontre = $tournamentId");
                            $result = $query->fetchAll();

                            foreach ($result as $row) {
                                $id = $row['id'];
                                $nomJoueur = $row['nom']." ".$row['prenom'];
                                $perf = $row['Performance'];
                                echo '<tr>';
                                echo '<td>'.$nomJoueur.'</td>';

                                echo '<td>'; echo "<input type='number' name='perf[]' value = '$perf' step='1' min='0' max='5'>"; echo "<input type='hidden' name='idJoueur[]' value='$id'>"; echo'</td>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
                    
                    
                </div>
                <input type="submit" id="valider" name="submit" value="Valider">
            </form>
        </main>


    </body>
</html>