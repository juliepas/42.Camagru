<?php
session_start();

require_once("../config/modele.php");

if ($_POST['comment'] && $_POST['commentaire'] && $_POST['id_img']) {
		$user = usersinfos($_SESSION['loggued_on_user']);
		if ($user[0]['login'] !== null) {
	        ajoutercomment($_POST['commentaire'], $_POST['id_img'], $_SESSION['loggued_on_user']);
	        //-------Mail-------
	        $mail = getusermail($_POST['id_img']);
	        $subject = "Nouveau commentaire !";
	        $message = "\n".$_SESSION['loggued_on_user']." a commenté votre photo ! Viens voir !\n";
	        mail($mail, $subject, $message);
	        //------------------
	        echo $user[0]['login'];
	    }
}
?>