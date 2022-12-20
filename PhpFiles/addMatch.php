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
        $bdd = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
    }catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    if(isset($_POST['addMatch'])) {
        $req = $bdd->prepare('insert into rencontre (nom, date, heure, lieu, equipeAdverse) VALUES (:nom, :date, :heure, :lieu, :adversaire)');
        if (!$req) {
            echo "<script>alert('Erreur, impossible d\'ajouter le match');</script>";
            header('Location: #');
        }
        $req->execute(array(
            'nom' => $_POST['name'],
            'date' => $_POST['date'],
            'heure' => $_POST['hour'],
            'lieu' => $_POST['lieu'],
            'adversaire' => $_POST['adversaire']
        ));
        if (!$req) {
            echo "<script>alert('Erreur, impossible d\'ajouter le match');</script>";
        }
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title> Ajouter un match </title>
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">
        

        

    </head>
    <body>
        <?php $_GET['page'] = 2;
        include "Menu.php"?>
        <main class='addMatchBody'>
            <div class="container">
                <h1 class="title">Ajouter un match </h1>
                <form method="post" action="addMatch.php">
                    <div class="matchDetails">
                        <div class="input-box">
                            <label for="name" class="details">Nom</label>
                            <input type="text" name ="name" placeholder="Entrez le nom" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Date</span>
                            <label>
                                <input type="date" name ="date" placeholder="Date du match" required>
                            </label>
                        </div>
                        <div class="input-box">
                            <span class="details">Heure</span>
                            <label>
                                <input type="time" name ="hour" placeholder="Heure du match" required>
                            </label>
                        </div>
                        <div class="input-box">
                            <span class="details">Lieu</span>
                            <label>
                                <input type="text" name ="lieu" placeholder="Entrez le lieu" required>
                            </label>
                        </div>
                        <div class="input-box">
                            <span class="details">Adversaire</span>
                            <label>
                                <input type="text" name ="adversaire" placeholder="Entrez le nom de l'équipe adverse" required>
                            </label>
                        </div>
                        
                    </div>
                    <div class="button">
                        <input type="submit" name="addMatch" value="Ajouter">
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>