<?PHP 
	session_start();
	if (!empty($_SESSION['id'])) {
		header('Location: ./PlayerList.php');
		exit();
	}
		
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		if ($_POST['username'] == "jeanRoure" && $_POST['password'] == "azertyuiop") {
			$id = session_id();
			if (empty($id)){
				session_start();
			}
			$_SESSION['id'] = session_id();
			header('Location: ./PlayerList.php');
		}
	}
	
	if (isset($_POST['username'])) {
		$user = $_POST['username'];
	} else {
		$user='';
	}
	
	
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <title> Ajouter un joueur </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/style.css">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </head>
	<body class="loginInBody">
        <div class="box">
            <div class="form">
                <h2> Connexion </h2>
                <form method="post" action="Login.php">
                    <div class="inputBox">
                        <input type="text" name='username' value="<?php echo $user ?>" required="required">
                        <span>Nom d'utilisateur</span>
                        <i></i>
                    </div>
                    <div class="inputBox">
                        <input type="password" name ="password" required="required">
                        <span>Mot de passe</span>
                        <i></i>
                    </div>
                    <input type="submit" value="Connexion">
                    <?php
                    if(isset($_POST['username']) || isset($_POST['password'])){
                        echo "<p class = 'texteErreur'> Erreur de connexion, veuillez ressayer</p>";
                    }
                    ?>
                </form>
            </div>
        </div>
	</body>
</html>