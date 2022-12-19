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
        #echo "<input list='playerList' name='playerName' placeholder='Entrez le nom du joueur' required>";
        #echo "<datalist id='playerList'>";
        echo "<select name='playerName[]' required>";
        echo "<option value=''>Entrez le nom du joueur</option>";
        $reponse = $bdd->query($query);
        if (!$reponse) {
            die('Erreur, impossible de récuperer la liste des joueurs pour la selection');
        }
        while ($donneesName = $reponse->fetch())
        {
            echo "<option value='".$donneesName['id']."' "; if ($donneesName['id']== $donnes['id']) {echo "selected";}                echo ">".$donneesName['nom']." ".$donneesName['prenom']."</option>";
        }
        #echo "</datalist>";
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
        /*echo "<select name='titulaire[]' required>";
        echo "<option value='' >Entrez le statut du joueur</option>";
        echo "<option value='1' >Titulaire</option>";
        echo "<option value='0'>Remplaçant</option>";
        echo "</select>";*/

        #if donnees['titulaire'] == 1
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
        echo "<select name='poste[]' required>";
        echo "<option value=''>Entrez le poste du joueur</option>";
        #poste = passeur, attaquant, receptionneurattaquant, central, libero
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
    
?>

<!DOCTYPE HTML>
    <html>
        <head>
            <title>Equipe</title>
            <link rel="stylesheet" href="../CSS/style.css">
            <meta charset="utf-8">
            <style>
                    select {
                        border: 0;
                        width: 100%;
                        height: 100%;
                        padding-left: 20px;
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        appearance: none;
                        background: url("http://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/br_down.png") white no-repeat 96%;
 
                    }

                    .abnormalities {
                        border: 3px solid red;
                        background-color: #FFBABA;
                        
                    }

                    select::-ms-expand { display: none; }

                    td {
                        padding : 0;
                        height:50px;
                    }

                    /* Tableau sur la gauche de la page */
                    #tableAddPlayer {
                        width: 50%;
                        float: left;
                    }

                    /*Bouton supprimer au milieu de sa cellule*/
                    #tableAddPlayer button {
                        margin: 0 auto;
                        display: block;
                    }

                    /*Bouton ajouter un joueur a droite de sa div*/
                    #addPlayerButton {
                        float: right;
                        text-align: right;
                    }
            </style>
        </head>

        <body>
            <?php $_GET['page'] = 2;
            include "Menu.php"?>
            <main>
                <h1 class="pageTitle"> Constitution de l'équipe </h1>
                
                <!-- Table sur la gauche de la page -->

                <form method="post" action="./setTeam.php?id=1">
                    <div id="tableAddPlayer">
                        
                            <table id='table'>
                                <tr>
                                    <th>Joueur</th>
                                    <th>Titulaire</th>
                                    <th>Poste</th>
                                    <th>Supprimer</th>
                                </tr>
                                <?php
                                    $reponse = $bdd->query("SELECT joueur.id, nom, prenom, postePrefere, poste, statut, idRencontre, estTitulaire  FROM joueur, participer where joueur.id = participer.idJoueur and idRencontre = $tournamentId");
                                    if (!$reponse) {
                                        die('Erreur, impossible de récuperer les joueurs de l\'équipe');
                                    }
                                    while ($donnees = $reponse->fetch())
                                    {
                                        if ($donnees["statut"] != 'Actif') {
                                            echo "<tr class = 'abnormalities'>";
                                        } else {
                                            echo "<tr>";
                                        }
                                        echo '<td>';selectName($bdd, $tournamentId,$donnees);echo '</td>';
                                        echo '<td>';selectTitulaire($bdd, $tournamentId,$donnees);echo '</td>';
                                        echo '<td>';selectPoste($bdd, $tournamentId,$donnees);echo '</td>';
                                        echo '<td><button type="button" onclick="deleteRow(this)">Supprimer</button></td>';
                                        if ($donnees["statut"] != 'Actif') {
                                            echo "<td>Joueur ".$donnees['statut']."</td>";
                                        }
                                        echo '</tr>';
                                    }
                                ?>
                            </table>
                        
                        <button type="button" id="addPlayerButton" onclick="addRow()">Ajouter un joueur</button>
                    </div>


                    <!-- Bouton valider en bas a droite -->
                    <div id="validateButton">
                        <input type=submit>Valider</button>
                    </div>
                </form>
            </main>


           
            
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
            cell1.innerHTML = previousRow.cells[0].innerHTML;
            cell1.getElementsByTagName('select')[0].value = "";
            cell2.innerHTML = previousRow.cells[1].innerHTML;
            cell2.getElementsByTagName('select')[0].value = "";
            cell3.innerHTML = previousRow.cells[2].innerHTML;
            cell3.getElementsByTagName('select')[0].value = "";
            cell4.innerHTML = previousRow.cells[3].innerHTML;

        }

        function deleteRow(ele) {
            var row = ele.closest('tr');
            row.parentNode.removeChild(row);
        }



    </script>
    </html>