<?php

    /*session_start();
    if (empty($_SESSION['id'])) {
        header('Location: https://localhost/ProjetPhp/login.php');
        exit();
    }*/

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
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        </head>

        <body>
            <?php $_GET['page'] = 1;
            include "Menu.php"?>
            <main>
                <h1 class="pageTitle"> Liste des joueurs </h1>

                <div class="addButton">
                    <button onclick="redirectModify()">Ajouter</button>
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
                        $req = $linkpdo->query('select id,nom, prenom, photo from joueur');
                        if(!$req) {
                            die("Error, can't fetch player list");
                        }
                        while($data = $req->fetch()){
                            echo '<tr>';
                                echo '<td>'.$data['nom'].'</td>';
                                echo '<td>'.$data['prenom'].'</td>';
                                echo '<td>'.$data['photo'].'</td>';
                                $id = $data['id'];
                                $customUrlModif = "ModifyPlayer.php?id=".$id;
                                //$customUrlDelete = "DeletePlayer.php?id=".$id;
                                echo '<td>'."<a href=".$customUrlModif.">Modifier</a>"." | "."<a onClick=confirmationRemove(".$id.")>Supprimer</a>".'</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    ?>
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

            <script>
                function redirectModify() {
                    location.href = "AddPlayer.php";
                }
            </script>
        </body>
    </html>

    <script>
        function confirmationRemove(id) {


            var confirmation = confirm("Voulez-vous vraiment supprimer ce joueur ?");
            if (confirmation) {
                location.href = "DeletePlayer.php?id="+id;
            }
        }