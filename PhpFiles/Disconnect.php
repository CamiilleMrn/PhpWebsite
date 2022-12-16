<?php

    if (!empty($_SESSION['id'])) {
        session_destroy();
        header('Location: ./PhpFiles/Login.php');
        exit();
    } else {
        header('Location: ./PhpFiles/ListPlayer.php');
    }

?>