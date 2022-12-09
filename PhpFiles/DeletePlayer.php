<?php
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

    $sql = "Delete from joueur where id = ?";
    $req = $linkpdo->prepare($sql);
    if(!$req) {
        die("Erreur requete");
    }
    $req->execute([$id]);
    if(!$req) {
        die("Erreur exec");
    }

    header('Location: /ProjetPhp/PhpFiles/PlayerList.php');
?>