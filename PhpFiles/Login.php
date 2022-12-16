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
<html>

	<head>
		<style>
			#sectionLogin {
				text-align:center;
				position:absolute;
				top: 50%;
				margin-top: -100px;
				left: 40%;
				right: 40%;
			}
			.texteErreur {
				color : red;
				position: fixed;
				left: 50%;
				transform: translate(-50%, 0);
			}
			
			fieldset{
			  border-color: blue;
			  border-style: solid;
			}
			
			fieldset > *{
				margin-top:10px;
			}
		</style>
	</head>
	<body>
		<section id='sectionLogin'>
			<form method='post' action='login.php'>
				<fieldset>
				<legend>Connection au service du club</legend>
					<label>Username </label><input type='text' name='username' value=<?php echo $user ?> > <br>
					<label>Password </label><input type='password' name='password'> <br>
					<input type='submit' value='Se connecter'>
					<section style="height: 40px;">
					<?php
						if (isset($_POST['username']) || isset($_POST['password'])) {
							echo "<p class = 'texteErreur'> Erreur de connexion, veuillez ressayer</p>";
						}
					?>
					</section>
				</fieldset>	
			
			</form>
		</section>
		

	</body>
</html>