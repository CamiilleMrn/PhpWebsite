<?php
    session_start();
    if (empty($_SESSION['id'])) {
        header('Location: /ProjetPhp/PhpFiles/login.php');
        exit();
    }
    if(!isset($_GET['id'])) {
        die ("Id non spécifié");
    }
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

    $fileUpdated = False;
    if (isset($_POST['Button'])) {
        $targetDir = "../../ProjetPhpPhotoJoueurs/";
        $targetFile = $targetDir . basename($_FILES['picture']['name']);
        chmod($targetDir, 0755);
        if ($_FILES['picture']['name'] != ""){
            $fileUpdated =True;
            $query = $linkpdo-> prepare("UPDATE joueur SET
                        nom = :nom,
                        prenom = :prenom ,
                        photo = :photo,
                        taille = :taille,
                        poid = :poid,
                        numeroLicense = :numLicense,
                        dateLicense = :dateLicense,
                        postePrefere = :posteFav,
                        Statut = :statut,
                        notes = :note
                        WHERE id = :id");
            echo "file changed";
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFile)) {
                $pictureUpdate = $targetDir . $_FILES['picture']['name'];
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            $query = $linkpdo-> prepare ("UPDATE joueur SET
                        nom = :nom,
                        prenom = :prenom ,
                        taille = :taille,
                        poid = :poid,
                        numeroLicense = :numLicense,
                        dateLicense = :dateLicense,
                        postePrefere = :posteFav,
                        Statut = :statut,
                        notes = :note
                        WHERE id = :id");

        }
        $nameUpdate = $_POST["name"];
        $surnameUpdate = $_POST["surname"];
        $heightUpdate = $_POST["height"];
        $weightUpdate = $_POST["weight"];
        $numLicenseUpdate = $_POST["numLicense"];
        $dateLicenseUpdate = $_POST["DateLicense"];
        $postUpdate = $_POST["post"];
        $statusUpdate = $_POST["status"];
        $notesUpdate = $_POST["note"];

        if($fileUpdated){
            $query->execute(array(':nom' => $nameUpdate,
                ':prenom' => $surnameUpdate,
                ':photo' => $pictureUpdate,
                ':taille' => $heightUpdate,
                ':poid' => $weightUpdate,
                ':numLicense' => $numLicenseUpdate,
                ':dateLicense' => $dateLicenseUpdate,
                ':posteFav' => $postUpdate,
                ':statut'=> $statusUpdate,
                ':note' => $notesUpdate,
                ':id'=> $id
            ));
        }else{
            $query->execute(array(':nom' => $nameUpdate,
                ':prenom' => $surnameUpdate,
                ':taille' => $heightUpdate,
                ':poid' => $weightUpdate,
                ':numLicense' => $numLicenseUpdate,
                ':dateLicense' => $dateLicenseUpdate,
                ':posteFav' => $postUpdate,
                ':statut'=> $statusUpdate,
                ':note' => $notesUpdate,
                ':id'=> $id
            ));
        }
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
        $height = $data['taille'];
        $weight = $data['poid'];
        $numLicense = $data['numeroLicense'];
        $dateLicense = $data['dateLicense'];
        $post = $data['postePrefere'];
        $status = $data['Statut'];
        $notes = $data['notes'];
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
                    <?PHP $url = "ModifyPlayer.php?id=$id";
                    echo "<form method='post' action=$url enctype='multipart/form-data'> ";?>
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
                                    <input type="file" name ="picture">  <span><?php echo $picture?></span>
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
                                    <input type="number" name ="numLicense" value="<?=$numLicense?>" required>
                                </label>
                            </div>
                            <div class="input-box">
                                <span class="details">Date obtention licence</span>
                                <label>
                                    <input type="date" name ="DateLicense" value=<?=$dateLicense?> required>
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
                    <?php echo "</form>"?>
                </div>
            </main>
            <?php include "Footer.php"?>
        </body>

    </html>

