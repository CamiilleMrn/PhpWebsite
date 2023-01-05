<?php

    session_start();
    if (empty($_SESSION['id'])) {
        header('Location: /ProjetPhp/PhpFiles/login.php');
        exit();
    }

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
                                $photoJ = $data['photo'];
                                if (file_exists($photoJ) ) {
                                    chmod($photoJ, 777);
                                }else{
                                    echo "file doesnt exist ";
                                }
                            echo '<td>'.'<img src="'.$photoJ.'"/>'.'</td>';
                                $id = $data['id'];
                                $customUrlModif = "ModifyPlayer.php?id=".$id;
                                //$customUrlDelete = "DeletePlayer.php?id=".$id;
                                echo '<td>'."<button onClick=modif(".$id.")>Modifier</button>"."  |  "."<button onClick=confirmationRemove(".$id.")>Supprimer</button>".'</td>';
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
                function modif(id){
                    location.href = "ModifyPlayer.php?id="+id;
                }
                function confirmationRemove(id) {
                    let text = "Confirmer la suppression du joueur ?";
                    if (confirm(text)) {
                        location.href = "DeletePlayer.php?id="+id;
                    }
                }

            </script>
        </body>
    </html>