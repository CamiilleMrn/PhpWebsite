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
    $server="127.0.0.1";
    $db="projectphp";
    $login="root";
    $mdp="";
    try {
        $bdd = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
    }catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    

    if (isset($_POST["playerName"]) and isset($_POST["titulaire"]) and isset($_POST["poste"])) {
        if (checkInput()) {

            $playerName = $_POST["playerName"];
            $titulaire = $_POST["titulaire"];
            $poste = $_POST["poste"];
            $query = "delete from participer where idRencontre = $tournamentId";
            $reponse = $bdd->query($query);
            if (!$reponse) {
                die('Erreur, impossible de supprimer les joueurs de la rencontre');
            }

            echo "<script>alert('Equipe enregistrée')</script>";
            $query = "insert into participer (idJoueur, idRencontre, estTitulaire, poste) values ";
            for ($i = 0; $i < count($playerName); $i++) {
                echo "InsertValues : ".$playerName[$i], $tournamentId, $titulaire[$i], $poste[$i];
                $query .= "($playerName[$i], $tournamentId, $titulaire[$i], '$poste[$i]')";
                if ($i != count($playerName) - 1) {
                    $query .= ", ";
                }
            }
            $reponse = $bdd->query($query);
            if (!$reponse) {
                die('Erreur, impossible d\'ajouter les joueurs à la rencontre');
            }
        }
        
    }

    function selectName($bdd, $tournamentId,$donnes) {
        $query = "select nom, prenom, id from joueur";
        if ($donnes['statut'] != "Actif") {
            echo "<select name='playerName[]' class = 'abnormalities' required>";
        } else {
            echo "<select name='playerName[]' required>";
        }
        echo "<option value=''>Entrez le nom du joueur</option>";
        $reponse = $bdd->query($query);
        if (!$reponse) {
            die('Erreur, impossible de récuperer la liste des joueurs pour la selection');
        }
        while ($donneesName = $reponse->fetch())
        {
            echo "<option value='".$donneesName['id']."' "; if ($donneesName['id']== $donnes['id']) {echo "selected";}                echo ">".$donneesName['nom']." ".$donneesName['prenom']."</option>";
        }
        echo "</select>";

    }

    

    function checkInput(){
        #check if two players have the same id

        $player = $_POST["playerName"];
        for ($i = 0; $i < count($player); $i++) {
            for ($j = $i + 1; $j < count($player); $j++) {
                if ($player[$i] == $player[$j]) {
                    echo "<script>alert('Un joueur ne peut pas être présent deux fois dans une équipe')</script>";
                    return false;
                }
            }
        }

        #check if there is at least one player in the team
        if (count($player) < 6) {
            echo "<script>alert('Il faut au moins 6 joueurs dans une équipe')</script>";
            return false;
        }

        return true;
        
    }

    function selectTitulaire($bdd, $tournamentId,$donnees) {
        echo "<select name='titulaire[]' required>";
        echo "<option value=''>Entrez le statut du joueur</option>";
        if ($donnees['estTitulaire'] == 1) {
            echo "<option value='1' selected>Titulaire</option>";
        } else {
            echo "<option value='1'>Titulaire</option>";
        }
        if ($donnees['estTitulaire'] == 0) {
            echo "<option value='0' selected>Remplaçant</option>";
        } else {
            echo "<option value='0'>Remplaçant</option>";
        }
        echo "</select>";

    }

    function selectPoste($bdd, $tournamentId,$donnees) {
        if ($donnees['postePrefere'] != $donnees['poste']) {
            echo "<select name='poste[]' class = 'abnormalities' required>";
        } else {
            echo "<select name='poste[]' required>";
        }
        echo "<option value=''>Entrez le poste du joueur</option>"; 
        if ($donnees['poste'] == "Passeur") {
            echo "<option value='Passeur' selected>Passeur</option>";
        } else {
            echo "<option value='Passeur'>Passeur</option>";
        }
        if ($donnees['poste'] == "Attaquant") {
            echo "<option value='Attaquant' selected>Attaquant</option>";
        } else {
            echo "<option value='Attaquant'>Attaquant</option>";
        }
        if ($donnees['poste'] == "ReceptionneurAttaquant") {
            echo "<option value='ReceptionneurAttaquant' selected>Receptionneur Attaquant</option>";
        } else {
            echo "<option value='ReceptionneurAttaquant'>Receptionneur Attaquant</option>";
        }
        if ($donnees['poste'] == "Central") {
            echo "<option value='Central' selected>Central</option>";
        } else {
            echo "<option value='Central'>Central</option>";
        }
        if ($donnees['poste'] == "Libero") {
            echo "<option value='Libero' selected>Libero</option>";
        } else {
            echo "<option value='Libero'>Libero</option>";
        }

        echo "</select>";
        
    }

    //Code select name
    echo "<script> var htmlName = '<select name=\'playerName[]\' required>' + '<option value=\'\'>Entrez le nom du joueur</option>'";
    $query = "select nom, prenom, id from joueur";
    $reponse = $bdd->query($query);
    if (!$reponse) {
        die('Erreur, impossible de récuperer la liste des joueurs pour la selection');
    }
    while ($donneesName = $reponse->fetch())
    {
        echo "+ '<option value=\'".$donneesName['id']."\'>".$donneesName['nom']." ".$donneesName['prenom']."</option>'";
    }
    echo "+ '</select>';\n";
    

    //Code select poste
    echo "var htmlPoste = '<select name=\'poste[]\' required>' + '<option value=\'\'>Entrez le poste du joueur</option>'";
    echo "+ '<option value=\'Passeur\'>Passeur</option>'";
    echo "+ '<option value=\'Attaquant\'>Attaquant</option>'";
    echo "+ '<option value=\'ReceptionneurAttaquant\'>Receptionneur Attaquant</option>'";
    echo "+ '<option value=\'Central\'>Central</option>'";
    echo "+ '<option value=\'Libero\'>Libero</option>'";
    echo "+ '</select>';\n";

    //Code select titulaire
    echo "var htmlTitulaire = '<select name=\'titulaire[]\' required>' + '<option value=\'\'>Entrez le statut du joueur</option>'";
    echo "+ '<option value=\'1\'>Titulaire</option>'";
    echo "+ '<option value=\'0\'>Remplaçant</option>'";
    echo "+ '</select>';\n";
    echo "</script>\n";


    
?>

<!DOCTYPE HTML>
    <html lang="fr">
        <head>
            <title>Equipe</title>
            <link rel="stylesheet" href="../CSS/style.css">
            <meta charset="utf-8">
        </head>

        <body>
            <?php $_GET['page'] = 2;
            include "Menu.php"?>
            <main>
                <h1 class="pageTitle"> Constitution de l'équipe </h1>
                
                <!-- Table sur la gauche de la page -->

                <form method="post" action="./setTeam.php?id=<?php echo $tournamentId?>">
                    <div id="tableAddPlayer">
                        
                            <table id='table'>
                                <tr>
                                    <th>Joueur</th>
                                    <th>Photo</th>
                                    <th>Taille</th>
                                    <th>Poids</th>
                                    <th>Titulaire</th>
                                    <th>Poste préféré</th>
                                    <th>Commentaire</th>
                                    <th>Evaluation</th>
                                    <th>Supprimer</th>
                                </tr>
                                <?php
                                    $reponse = $bdd->query("SELECT joueur.id, nom, prenom, photo, taille, poid, notes, postePrefere, poste, statut, idRencontre, estTitulaire  FROM joueur, participer where joueur.id = participer.idJoueur and idRencontre = $tournamentId");
                                    if (!$reponse) {
                                        die('Erreur, impossible de récuperer les joueurs de l\'équipe');
                                    }
                                    while ($donnees = $reponse->fetch())
                                    {
                                        
                                        
                                        
                                        echo "<tr>";
                                        echo '<td>';selectName($bdd, $tournamentId,$donnees);
                                        if ($donnees["statut"] != 'Actif') {
                                            $texteTooltip = "/!\\<br> Attention, Le statut du joueur est ".$donnees['statut'];
                                            echo "<span class='tooltipSuggestion'>$texteTooltip</span>";
                                        }
                                        echo '</td>';
                                        echo '<td>'.'<img src='.$donnees['photo'].'>'.'</td>';
                                        echo '<td>'.$donnees['taille'].'</td>';
                                        echo '<td>'.$donnees['poid'].'</td>';
                                        echo '<td>';selectTitulaire($bdd, $tournamentId,$donnees);echo '</td>';
                                        echo '<td>';selectPoste($bdd, $tournamentId,$donnees);
                                        if ($donnees["postePrefere"] != $donnees["poste"]) {
                                            $texteTooltip = "/!\\<br> Attention, le poste préféré du joueur est ".$donnees['postePrefere'];
                                            echo "<span class='tooltipSuggestion'>$texteTooltip</span>";
                                        }
                                        echo '</td>';
                                        echo '<td>'.$donnees['notes'].'</td>';
                                        echo '<td>'.$donnees['notes'].'</td>';
                                        echo '<td><button type="button" onclick="deleteRow(this)">Supprimer</button>';echo '</td>';
                                        if ($donnees["statut"] != 'Actif') {
                                            echo "<td>Joueur ".$donnees['statut'];echo "</td>";
                                        }
                                        echo '</tr>';
                                    }
                                ?>
                            </table>
                        
                        <button type="button" id="addPlayerButton" onclick="addRow()">Ajouter un joueur</button>
                    </div>


                    <!-- Bouton valider en bas a droite -->
                    <div id="validateButton">
                        <?php
                            //echo "<button onClick=setTeam(".$tournamentId.")>Valider</button>";
                            //cho "<a href='/ProjetPhp/PhpFiles/setTeam.php?id=$tournamentId' >Valider</a>"
                        ?>
                        <input type=submit value="Valider"/>
                    </div>
                </form>
            </main>
            <?php include "Footer.php"?>
        </body>
    <script>
        function addRow() {
            var table = document.getElementById('table');
            var previousRow = table.rows[table.rows.length - 1];
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            var cell8 = row.insertCell(7);
            var cell9 = row.insertCell(8);
            cell1.innerHTML = htmlName;
            cell5.innerHTML = htmlTitulaire;
            cell6.innerHTML = htmlPoste;
            cell9.innerHTML = "<button type='button' onclick='deleteRow(this)'>Supprimer</button>";

        }

        function deleteRow(ele) {
            var row = ele.closest('tr');
            row.parentNode.removeChild(row);
        }
    </script>
    </html>