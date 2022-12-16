<?php
    /*session_start();
    if (empty($_SESSION['id'])) {
        header('Location: https://localhost/ProjetPhp/login.php');
        exit();
    }*/
    $id = $_GET['id'];

    $server="localhost";
    $db="projectphp";
    $login="root";
    $mdp="";
    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
    }catch (Exception $e){
        die('Error : ' . $e->getMessage());
    }

    $req = $linkpdo-> prepare('select nom, prenom, photo, taille, poid, numeroLicense, dateLicense, postePrefere, 
       Statut, notes from joueur where id = ?');
    $req-> execute([$id]);
    if (!$req){
        die('Error on select');
    }
    while($data = $req->fetch()){
        $name = $data['nom'];
        $surname = $data['prenom'];
        $picture = $data['photo'];
        $height = $data['photo'];
        $weight = $data['poid'];
        $numLicense = $data['numeroLicense'];
        $dateLicense = $data['dateLicense'];
        $post = $data['postePrefere'];
        $status = $data['Statut'];
        $notes = $data['notes'];
    }
    //
    if (isset($_POST['Button'])) {
        $req = $linkpdo->prepare('UPDATE joueur SET
                                nom = :nom,
                                prenom = :prenom,
                                photo = :photo,
                                taille = :taille,
                                poid = :poid,
                                numeroLicense = :numeroLicense,
                                dateLicense = :dateLicense,
                                postePrefere = :postePrefere,
                                Statut = :Statut,
                                notes = :notes
                                WHERE id = "$id"');
        $req->execute(array(
            'nom' => $_POST['name'],
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
            die('Error on update');
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
            <main class ="modifyPlayerBody">
                <div class="container">
                    <div class="title">Modification</div>
                    <form method="post" action="ModifyPlayer.php">
                        <div class="playerDetails">
                            <div class="input-box">
                                <span class="details">Nom</span>
                                <label>
                                    <input type="text" name ="name" value="<?=$name?>" required>
                                </label>
                            </div>
                            <div class="input-box">
                                <span class="details">Prénom</span>
                                <label>
                                    <input type="text" name ="surname" value="<?=$surname?>" required>
                                </label>
                            </div>
                            <div class="input-box">
                                <span class="details">Photo</span>
                                <label>
                                    <input type="text" name ="picture" value="<?=$picture?>" required>
                                </label>
                            </div>
                            <div class="input-box">
                                <span class="details">Taille</span>
                                <label>
                                    <input type="number" step="0.01" name ="height" value="<?=$height?>" required>
                                </label>
                            </div>
                            <div class="input-box">
                                <span class="details">Poids</span>
                                <label>
                                    <input type="number" step="0.01" name ="weight" value="<?=$weight?>" required>
                                </label>
                            </div>
                            <div class="input-box">
                                <span class="details">Num licence</span>
                                <label>
                                    <input type="text" name ="numLicense" value="<?=$numLicense?>" required>
                                </label>
                            </div>
                            <div class="input-box">
                                <span class="details">Date obtention licence</span>
                                <label>
                                    <input type="text" name ="DateLicense" value="<?=$dateLicense?>" required>
                                </label>
                            </div>
                            <div class="input-box">
                                <label for="postSelected">Poste favori</label>
                                <select name="post" id="postSelected">
                                    <option value="<?=$post?>"><?=$post?></option>
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
                                    <option value="<?=$status?>"><?=$status?></option>
                                    <option value="Actif">Actif</option>
                                    <option value="Blessé">Blessé</option>
                                    <option value="Suspendu">Suspendu</option>
                                    <option value="Absent">Absent</option>
                                </select>
                            </div>
                            <div class="input-box">
                                <span class="details">Note</span>
                                <label>
                                    <input type="text" name ="note" value="<?=$notes?>"">
                                </label>
                            </div>
                        </div>
                        <div class="button">
                            <input type="submit" name="Button" value="Enregister">
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

