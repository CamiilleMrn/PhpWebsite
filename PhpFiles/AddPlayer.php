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

    if (isset($_POST['Button'])) {
        $req = $linkpdo->prepare('INSERT INTO joueur(nom,prenom,photo,taille,poid,numeroLicense,dateLicense,postePrefere,Statut,notes)
                            VALUES(:nom,:prenom,:photo,:taille,:poid,:numeroLicense,:dateLicense,:postePrefere,:Statut,:notes)');
        $req->execute(array('nom' => $_POST['name'],
            'prenom' => $_POST['surname'],
            'photo' => $_POST['picture'],
            'taille' => $_POST['height'],
            'poid' => $_POST['weight'],
            'numeroLicense' => $_POST['numLicense'],
            'dateLicense' => $_POST['DateLicense'],
            'postePrefere' => $_POST['post'],
            'Statut' => $_POST['status'],
            'notes' => $_POST['note'],
        ));
        if(!$req){
            die('Error on insert');
        }
    }
?>

<!DOCTYPE>
    <html lang="fr">
        <head>
            <title> Ajouter un joueur </title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../CSS/style.css">
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        </head>

        <body>
            <?php $_GET['page'] = 1;
            include "Menu.php"?>
            <main class ="addPlayerBody">
                <div class="container">
                    <div class="title">Inscription </div>
                        <form method="post" action="AddPlayer.php">
                            <div class="playerDetails">
                                <div class="input-box">
                                    <span class="details">Nom</span>
                                    <label>
                                        <input type="text" name ="name" placeholder="Entrez le nom" required>
                                    </label>
                                </div>
                                <div class="input-box">
                                    <span class="details">Prénom</span>
                                    <label>
                                        <input type="text" name ="surname" placeholder="Entrez le prénom" required>
                                    </label>
                                </div>
                                <div class="input-box">
                                    <span class="details">Photo</span>
                                    <label>
                                        <input type="text" name ="picture" placeholder="Entrez la photo" required>
                                    </label>
                                </div>
                                <div class="input-box">
                                    <span class="details">Taille</span>
                                    <label>
                                        <input type="number" step="0.01" name ="height" placeholder="Entrez la taille" required>
                                    </label>
                                </div>
                                <div class="input-box">
                                    <span class="details">Poids</span>
                                    <label>
                                        <input type="number" step="0.01" name ="weight" placeholder="Entrez le poid" required>
                                    </label>
                                </div>
                                <div class="input-box">
                                    <span class="details">Num licence</span>
                                    <label>
                                        <input type="text" name ="numLicense" placeholder="Entrez le numéro de license" required>
                                    </label>
                                </div>
                                <div class="input-box">
                                    <span class="details">Date obtention licence</span>
                                    <label>
                                        <input type="text" name ="DateLicense" placeholder="Entrez la date d'obtention license" required>
                                    </label>
                                </div>
                                <div class="input-box">
                                    <label for="postSelected">Poste favori</label>
                                        <select name="post" id="postSelected">
                                            <option value="">--Choisissez une option--</option>
                                            <option value="Attaquant">Attaquant</option>
                                            <option value="Passeur">Passeur</option>
                                            <option value="ReceptionneurAttaquant">Receptionneur-Attaquant</option>
                                            <option value="Central">Central</option>
                                            <option value="Libero">Libero</option>
                                    </select>
                                </div>
                                <div class="input-box">
                                    <label for="statusSelected">Satut</label>
                                    <select name="status" id="statusSelected">
                                        <option value="">--Choisissez une option--</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Blessé">Blessé</option>
                                        <option value="Suspendu">Suspendu</option>
                                        <option value="Absent">Absent</option>
                                    </select>
                                </div>
                                <div class="input-box">
                                    <span class="details">Note</span>
                                    <label>
                                        <input type="text" name ="note" placeholder="Entrez la note">
                                    </label>
                                </div>
                            </div>
                            <div class="button">
                                <input type="submit" name="Button" value="Inscrire">
                            </div>
                        </form>
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

    </html>
