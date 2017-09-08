<?php
    require_once("vue/navbar.php");
    require_once("vue/vueAccueil.php");
    require_once("vue/footer.php");
?>

<script src="https://use.fontawesome.com/1bac96d422.js"></script>
<script src="js/connexion.js"></script>
<?php if ($_SESSION['loggued_on_user'] != NULL && $_GET['action'] != "afficher" && $_GET['action'] != "moncompte"): ?>
        <script src="js/stream.js"></script>
<?php endif; ?>