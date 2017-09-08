<?php
    require_once("header.php");
?>

<html>
    <body>
        <nav>
            <div class="navbarleft">
                <p>
                    <i class="fa fa-camera" aria-hidden="true"></i>
                    <a href="index.php">Camagru</a>
                </p>
            </div>
            <button id="yummi" onclick="ham()">&#9776;</button>
            <div class="navbarright">
                <ul id="menu">
                    <?php if ($_SESSION['loggued_on_user'] == NULL): ?>
                        <li id="btn-modalconnexion">Connexion</li>
                        <li id="btn-modal">Inscription</li>
                    <?php else: ?>
                        <li><a href="controleur/sign.php?action=deconnexion">Déconnexion</a></li>
                        <li><a href="index.php?action=moncompte">Bienvenue <?php echo htmlentities($_SESSION['loggued_on_user']) ?></a></li>
                    <?php endif ?>
                        <li><a href="index.php?action=galerie">Galerie</a></li>
                </ul>
            </div>
        </nav>
    </body>
</html>