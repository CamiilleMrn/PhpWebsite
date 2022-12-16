<?php
    if (isset($_GET['page']) && !empty($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        die ("Erreur de chargement de la page, menu non scpécifié");
    }
?>
<header>
    <nav class="menu">
        <input type="checkbox" id="check">
        <label for="check" class="checkBtn">
            <i class="fas fa-bars" ></i>
        </label>
        
        <label class="logo"><img src="../ProjetPhpPhoto/LogoSite.jpg" alt="Logo du site"/></label>
        <ul>
            <li> <a <?php if($page==1) {echo"class='active'";} ?> href="PlayerList.php"> Liste des joueurs</a> </li>
            <li> <a <?php if($page==2) {echo"class='active'";} ?> href="MatchList.php"> Liste des matchs</a> </li>
            <li> <a <?php if($page==3) {echo"class='active'";} ?> href="StatPage.php"> Statistiques des joueurs</a> </li>
        </ul>
    </nav>
</header>