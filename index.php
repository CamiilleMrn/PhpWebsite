<?php
    session_start();
	if (!empty($_SESSION['id'])) {
		header('Location: ./PhpFiles/PlayerList.php');
		exit();
	} else {
        header('Location: ./PhpFiles/Login.php');
    }

?>