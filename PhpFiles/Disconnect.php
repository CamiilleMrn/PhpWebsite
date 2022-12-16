<?php

    session_start();
    session_destroy();
    header('Location: /ProjetPhp/PhpFiles/Login.php');

?>